<?php
/**
 * Lead CRM - Reports
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();

$pageTitle = 'Reports';
$db = db();

// Date range
$dateFrom = $_GET['date_from'] ?? date('Y-m-01');
$dateTo = $_GET['date_to'] ?? date('Y-m-d');

// Client filter
$clientWhere = '';
$params = ['date_from' => $dateFrom, 'date_to' => $dateTo];
if (!isAdmin() && getCurrentClientId()) {
    $clientWhere = " AND client_id = :client_id";
    $params['client_id'] = getCurrentClientId();
}

// Get report data
$totalLeads = $db->fetch(
    "SELECT COUNT(*) as count FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere}",
    $params
)['count'];

$conversionRate = 0;
if ($totalLeads > 0) {
    $wonLeads = $db->fetch(
        "SELECT COUNT(*) as count FROM leads WHERE status = 'won' AND DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere}",
        $params
    )['count'];
    $conversionRate = round(($wonLeads / $totalLeads) * 100, 1);
}

// Leads by status
$leadsByStatus = $db->fetchAll(
    "SELECT status, COUNT(*) as count FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere} GROUP BY status",
    $params
);

// Leads by source
$leadsBySource = $db->fetchAll(
    "SELECT COALESCE(utm_source, 'Direct') as source, COUNT(*) as count 
     FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere} 
     GROUP BY utm_source ORDER BY count DESC",
    $params
);

// Leads by campaign
$leadsByCampaign = $db->fetchAll(
    "SELECT COALESCE(utm_campaign, 'None') as campaign, COUNT(*) as count,
            SUM(CASE WHEN status = 'won' THEN 1 ELSE 0 END) as won
     FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere} 
     GROUP BY utm_campaign ORDER BY count DESC LIMIT 10",
    $params
);

// Leads by date
$leadsByDate = $db->fetchAll(
    "SELECT DATE(lead_timestamp) as date, COUNT(*) as count 
     FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere} 
     GROUP BY DATE(lead_timestamp) ORDER BY date",
    $params
);

// Leads by location
$leadsByLocation = $db->fetchAll(
    "SELECT COALESCE(city, 'Unknown') as city, COALESCE(country, 'Unknown') as country, COUNT(*) as count 
     FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to {$clientWhere} 
     GROUP BY city, country ORDER BY count DESC LIMIT 10",
    $params
);

// Quality distribution
$qualityDistribution = $db->fetchAll(
    "SELECT quality_score, COUNT(*) as count 
     FROM leads WHERE DATE(lead_timestamp) BETWEEN :date_from AND :date_to AND quality_score > 0 {$clientWhere} 
     GROUP BY quality_score ORDER BY quality_score",
    $params
);

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Reports</h2>
            <p class="text-muted mb-0">Analyze your lead performance</p>
        </div>
    </div>
    
    <!-- Date Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control" value="<?= e($dateFrom) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control" value="<?= e($dateTo) ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter me-1"></i>Apply Filter
                    </button>
                    <a href="?date_from=<?= date('Y-m-01') ?>&date_to=<?= date('Y-m-d') ?>" class="btn btn-outline-secondary">
                        This Month
                    </a>
                </div>
                <div class="col-md-3 text-end">
                    <a href="leads.php?export=csv&date_from=<?= e($dateFrom) ?>&date_to=<?= e($dateTo) ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-download me-1"></i>Export CSV
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon bg-primary bg-gradient">
                        <i class="bi bi-people"></i>
                    </div>
                    <h2 class="stat-value mt-3"><?= number_format($totalLeads) ?></h2>
                    <p class="stat-label mb-0">Total Leads</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon bg-success bg-gradient">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h2 class="stat-value mt-3"><?= $conversionRate ?>%</h2>
                    <p class="stat-label mb-0">Conversion Rate</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon bg-info bg-gradient">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h2 class="stat-value mt-3"><?= count($leadsBySource) ?></h2>
                    <p class="stat-label mb-0">Traffic Sources</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="stat-icon bg-warning bg-gradient">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <h2 class="stat-value mt-3"><?= count($leadsByCampaign) ?></h2>
                    <p class="stat-label mb-0">Active Campaigns</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Leads Over Time</h5>
                </div>
                <div class="card-body">
                    <canvas id="trendsChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Status Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Source & Campaign -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Leads by Source</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Source</th>
                                    <th>Leads</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leadsBySource as $source): ?>
                                    <tr>
                                        <td><?= e($source['source']) ?></td>
                                        <td><?= number_format($source['count']) ?></td>
                                        <td><?= $totalLeads > 0 ? round(($source['count'] / $totalLeads) * 100, 1) : 0 ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Campaign Performance</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Campaign</th>
                                    <th>Leads</th>
                                    <th>Won</th>
                                    <th>Conv %</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leadsByCampaign as $campaign): ?>
                                    <tr>
                                        <td><?= e($campaign['campaign']) ?></td>
                                        <td><?= number_format($campaign['count']) ?></td>
                                        <td><?= number_format($campaign['won']) ?></td>
                                        <td><?= $campaign['count'] > 0 ? round(($campaign['won'] / $campaign['count']) * 100, 1) : 0 ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Location -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Geographic Distribution</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Leads</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leadsByLocation as $loc): ?>
                                    <tr>
                                        <td>
                                            <i class="bi bi-geo-alt text-muted me-1"></i>
                                            <?= e($loc['city']) ?>, <?= e($loc['country']) ?>
                                        </td>
                                        <td><?= number_format($loc['count']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Quality Score Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="qualityChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const colors = [
    'rgba(99, 102, 241, 0.8)',
    'rgba(16, 185, 129, 0.8)',
    'rgba(245, 158, 11, 0.8)',
    'rgba(239, 68, 68, 0.8)',
    'rgba(107, 114, 128, 0.8)'
];

// Trends Chart
new Chart(document.getElementById('trendsChart'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($leadsByDate, 'date')) ?>,
        datasets: [{
            label: 'Leads',
            data: <?= json_encode(array_column($leadsByDate, 'count')) ?>,
            borderColor: 'rgba(99, 102, 241, 1)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: '#9ca3af' } },
            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } }
        }
    }
});

// Status Chart
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_map(function($s) { return ucfirst($s['status']); }, $leadsByStatus)) ?>,
        datasets: [{
            data: <?= json_encode(array_column($leadsByStatus, 'count')) ?>,
            backgroundColor: colors,
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { color: '#9ca3af' } }
        }
    }
});

// Quality Chart
new Chart(document.getElementById('qualityChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($qualityDistribution, 'quality_score')) ?>,
        datasets: [{
            label: 'Leads',
            data: <?= json_encode(array_column($qualityDistribution, 'count')) ?>,
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: '#9ca3af' } },
            y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#9ca3af' } }
        }
    }
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
