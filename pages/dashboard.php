<?php
/**
 * Lead CRM - Dashboard
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();

$pageTitle = 'Dashboard';
$stats = getDashboardStats();
$recentLeads = getLeads([], 10);
$leadsBySource = getLeadsBySource();
$leadsByCampaign = getLeadsByCampaign();

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <!-- Welcome -->
    <div class="mb-4">
        <h2 class="mb-1">Welcome back, <?= e($_SESSION['user_name']) ?>! 👋</h2>
        <p class="text-muted mb-0">Here's what's happening with your leads today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="stat-icon bg-primary bg-gradient">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <span class="badge bg-success-subtle text-success">Today</span>
                    </div>
                    <h2 class="stat-value mt-3"><?= number_format($stats['today']) ?></h2>
                    <p class="stat-label mb-0">Leads Today</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="stat-icon bg-info bg-gradient">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                        <span class="badge bg-info-subtle text-info">This Week</span>
                    </div>
                    <h2 class="stat-value mt-3"><?= number_format($stats['this_week']) ?></h2>
                    <p class="stat-label mb-0">Leads This Week</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="stat-icon bg-warning bg-gradient">
                            <i class="bi bi-calendar-month"></i>
                        </div>
                        <span class="badge bg-warning-subtle text-warning">This Month</span>
                    </div>
                    <h2 class="stat-value mt-3"><?= number_format($stats['this_month']) ?></h2>
                    <p class="stat-label mb-0">Leads This Month</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="stat-icon bg-success bg-gradient">
                            <i class="bi bi-trophy"></i>
                        </div>
                        <span
                            class="badge bg-success-subtle text-success"><?= round($stats['total'] > 0 ? ($stats['won'] / $stats['total']) * 100 : 0) ?>%</span>
                    </div>
                    <h2 class="stat-value mt-3"><?= number_format($stats['won']) ?></h2>
                    <p class="stat-label mb-0">Converted Leads</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Leads by Source</h5>
                </div>
                <div class="card-body">
                    <canvas id="sourceChart" height="260"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Leads by Campaign</h5>
                </div>
                <div class="card-body">
                    <canvas id="campaignChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Overview & Recent Leads -->
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Lead Status</h5>
                </div>
                <div class="card-body">
                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-primary"></span>
                            <span>New</span>
                        </div>
                        <span class="badge bg-primary"><?= $stats['new'] ?></span>
                    </div>
                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-info"></span>
                            <span>Contacted</span>
                        </div>
                        <span class="badge bg-info"><?= $stats['contacted'] ?></span>
                    </div>
                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-warning"></span>
                            <span>Qualified</span>
                        </div>
                        <span class="badge bg-warning"><?= $stats['qualified'] ?></span>
                    </div>
                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-success"></span>
                            <span>Won</span>
                        </div>
                        <span class="badge bg-success"><?= $stats['won'] ?></span>
                    </div>
                    <div class="status-item d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-danger"></span>
                            <span>Lost</span>
                        </div>
                        <span class="badge bg-danger"><?= $stats['lost'] ?></span>
                    </div>
                    <div class="status-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="status-dot bg-secondary"></span>
                            <span>Total</span>
                        </div>
                        <span class="badge bg-secondary"><?= $stats['total'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Leads</h5>
                    <a href="leads.php" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Lead</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentLeads)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No leads yet. Configure your webhook to start receiving leads.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($recentLeads as $lead): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <?= strtoupper(substr($lead['name'] ?? 'N', 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold"><?= e($lead['name'] ?? 'N/A') ?></div>
                                                        <small class="text-muted"><?= e($lead['email'] ?? '') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted"><?= e($lead['utm_source'] ?? 'Direct') ?></span>
                                            </td>
                                            <td><?= getStatusBadge($lead['status']) ?></td>
                                            <td>
                                                <small class="text-muted"><?= timeAgo($lead['created_at']) ?></small>
                                            </td>
                                            <td>
                                                <a href="lead-detail.php?id=<?= $lead['id'] ?>"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart colors - softer pastels for light theme
    const colors = [
        'rgba(99, 102, 241, 0.7)',    // Indigo
        'rgba(167, 139, 250, 0.7)',   // Purple  
        'rgba(103, 232, 249, 0.7)',   // Cyan
        'rgba(134, 239, 172, 0.7)',   // Green
        'rgba(253, 224, 71, 0.7)',    // Yellow
        'rgba(253, 186, 116, 0.7)',   // Orange
        'rgba(240, 171, 252, 0.7)',   // Pink
        'rgba(6, 182, 212, 0.7)'      // Teal
    ];

    // Source Chart
    const sourceCtx = document.getElementById('sourceChart').getContext('2d');
    new Chart(sourceCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($leadsBySource, 'source')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($leadsBySource, 'count')) ?>,
                backgroundColor: colors,
                borderWidth: 3,
                borderColor: 'rgba(255, 255, 255, 0.8)',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#64748b',
                        font: { size: 13, weight: 500 },
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            }
        }
    });

    // Campaign Chart
    const campaignCtx = document.getElementById('campaignChart').getContext('2d');
    new Chart(campaignCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($leadsByCampaign, 'campaign')) ?>,
            datasets: [{
                label: 'Leads',
                data: <?= json_encode(array_column($leadsByCampaign, 'count')) ?>,
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderRadius: 10,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(99, 102, 241, 0.85)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: { size: 12 }
                    },
                    border: { color: 'rgba(99, 102, 241, 0.12)' }
                },
                y: {
                    grid: {
                        color: 'rgba(99, 102, 241, 0.08)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        font: { size: 12 }
                    },
                    border: { display: false }
                }
            }
        }
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>