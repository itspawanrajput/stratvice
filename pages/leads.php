<?php
/**
 * Lead CRM - Leads List
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();

$pageTitle = 'Leads';

// Handle export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $leads = getLeads($_GET);
    exportLeadsToCsv($leads);
}

// Get filters from query string
$filters = [
    'status' => $_GET['status'] ?? '',
    'utm_source' => $_GET['utm_source'] ?? '',
    'utm_campaign' => $_GET['utm_campaign'] ?? '',
    'date_from' => $_GET['date_from'] ?? '',
    'date_to' => $_GET['date_to'] ?? '',
    'search' => $_GET['search'] ?? ''
];

// Pagination
$perPage = 25;
$page = max(1, (int) ($_GET['page'] ?? 1));
$totalLeads = getLeadsCount($filters);
$totalPages = max(1, ceil($totalLeads / $perPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $perPage;

$leads = getLeads($filters, $perPage, $offset);

// Get unique sources and campaigns (scoped to client)
$db = db();
$clientScope = '';
$scopeParams = [];
if (!isAdmin() && getCurrentClientId()) {
    $clientScope = " AND client_id = :client_id";
    $scopeParams['client_id'] = getCurrentClientId();
}
$sources = $db->fetchAll("SELECT DISTINCT utm_source FROM leads WHERE utm_source IS NOT NULL AND utm_source != '' {$clientScope} ORDER BY utm_source", $scopeParams);
$campaigns = $db->fetchAll("SELECT DISTINCT utm_campaign FROM leads WHERE utm_campaign IS NOT NULL AND utm_campaign != '' {$clientScope} ORDER BY utm_campaign", $scopeParams);

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Leads</h2>
            <p class="text-muted mb-0">Manage and track all your leads</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-primary d-flex align-items-center" style="font-size: 14px;"><?= number_format($totalLeads) ?> leads</span>
            <a href="?export=csv&<?= http_build_query($filters) ?>" class="btn btn-outline-secondary">
                <i class="bi bi-download me-1"></i>Export CSV
            </a>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Name, email, phone..." value="<?= e($filters['search']) ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="new" <?= $filters['status'] === 'new' ? 'selected' : '' ?>>New</option>
                        <option value="contacted" <?= $filters['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                        <option value="qualified" <?= $filters['status'] === 'qualified' ? 'selected' : '' ?>>Qualified</option>
                        <option value="won" <?= $filters['status'] === 'won' ? 'selected' : '' ?>>Won</option>
                        <option value="lost" <?= $filters['status'] === 'lost' ? 'selected' : '' ?>>Lost</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Source</label>
                    <select name="utm_source" class="form-select">
                        <option value="">All Sources</option>
                        <?php foreach ($sources as $s): ?>
                            <option value="<?= e($s['utm_source']) ?>" <?= $filters['utm_source'] === $s['utm_source'] ? 'selected' : '' ?>>
                                <?= e($s['utm_source']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">From</label>
                    <input type="date" name="date_from" class="form-control" value="<?= e($filters['date_from']) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">To</label>
                    <input type="date" name="date_to" class="form-control" value="<?= e($filters['date_to']) ?>">
                </div>
                <div class="col-md-1 d-flex align-items-end gap-1">
                    <button type="submit" class="btn btn-primary flex-grow-1" title="Filter">
                        <i class="bi bi-funnel"></i>
                    </button>
                    <a href="leads.php" class="btn btn-outline-secondary" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Leads Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="leadsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lead</th>
                            <th>Contact</th>
                            <th>Source / Campaign</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Quality</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($leads)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No leads found matching your criteria.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($leads as $lead): ?>
                                <tr>
                                    <td>#<?= $lead['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <?= strtoupper(substr($lead['name'] ?? 'N', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold"><?= e($lead['name'] ?? 'N/A') ?></div>
                                                <?php if (!empty($lead['form_name'])): ?>
                                                    <small class="text-muted"><?= e($lead['form_name']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <?php if (!empty($lead['phone'])): ?>
                                                <a href="tel:<?= e($lead['phone']) ?>" class="text-decoration-none">
                                                    <i class="bi bi-telephone text-muted me-1"></i><?= e($lead['phone']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if (!empty($lead['email'])): ?>
                                                <a href="mailto:<?= e($lead['email']) ?>" class="text-muted text-decoration-none small">
                                                    <i class="bi bi-envelope me-1"></i><?= e($lead['email']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-medium"><?= e($lead['utm_source'] ?? 'Direct') ?></div>
                                        <small class="text-muted"><?= e($lead['utm_campaign'] ?? '-') ?></small>
                                    </td>
                                    <td>
                                        <?php if (!empty($lead['city'])): ?>
                                            <i class="bi bi-geo-alt text-muted me-1"></i>
                                            <?= e($lead['city']) ?><?= !empty($lead['country']) ? ', ' . e($lead['country']) : '' ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= getStatusBadge($lead['status']) ?></td>
                                    <td><?= getQualityBadge($lead['quality_score']) ?></td>
                                    <td>
                                        <div><?= formatDate($lead['lead_timestamp']) ?></div>
                                        <small class="text-muted"><?= timeAgo($lead['created_at']) ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="lead-detail.php?id=<?= $lead['id'] ?>" class="btn btn-outline-primary" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if (!empty($lead['phone'])): ?>
                                                <a href="tel:<?= e($lead['phone']) ?>" class="btn btn-outline-success" title="Call">
                                                    <i class="bi bi-telephone"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($lead['phone'])): ?>
                                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $lead['phone']) ?>" target="_blank" class="btn btn-outline-secondary" title="WhatsApp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if ($totalPages > 1): ?>
        <div class="card-footer d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing <?= number_format($offset + 1) ?>–<?= number_format(min($offset + $perPage, $totalLeads)) ?> of <?= number_format($totalLeads) ?> leads
            </small>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    $queryParams = $filters;
                    
                    // Previous
                    if ($page > 1) {
                        $queryParams['page'] = $page - 1;
                        echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryParams) . '"><i class="bi bi-chevron-left"></i></a></li>';
                    }
                    
                    // Page numbers
                    $startPage = max(1, $page - 2);
                    $endPage = min($totalPages, $page + 2);
                    
                    if ($startPage > 1) {
                        $queryParams['page'] = 1;
                        echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryParams) . '">1</a></li>';
                        if ($startPage > 2) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                    }
                    
                    for ($i = $startPage; $i <= $endPage; $i++) {
                        $queryParams['page'] = $i;
                        $active = $i === $page ? ' active' : '';
                        echo '<li class="page-item' . $active . '"><a class="page-link" href="?' . http_build_query($queryParams) . '">' . $i . '</a></li>';
                    }
                    
                    if ($endPage < $totalPages) {
                        if ($endPage < $totalPages - 1) echo '<li class="page-item disabled"><span class="page-link">…</span></li>';
                        $queryParams['page'] = $totalPages;
                        echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryParams) . '">' . $totalPages . '</a></li>';
                    }
                    
                    // Next
                    if ($page < $totalPages) {
                        $queryParams['page'] = $page + 1;
                        echo '<li class="page-item"><a class="page-link" href="?' . http_build_query($queryParams) . '"><i class="bi bi-chevron-right"></i></a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
