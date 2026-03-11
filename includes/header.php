<?php
/**
 * Lead CRM - Header Template
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6366f1">
    <title><?= e($pageTitle ?? 'Dashboard') ?> - <?= APP_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="bi bi-heart-pulse"></i>
            </div>
            <span class="sidebar-brand">Lead Gravity</span>
        </div>

        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= APP_URL ?>/pages/dashboard.php"
                        class="nav-link <?= ($pageTitle ?? '') === 'Dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-grid-1x2"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= APP_URL ?>/pages/leads.php"
                        class="nav-link <?= ($pageTitle ?? '') === 'Leads' ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        <span class="nav-link-text">Leads</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= APP_URL ?>/pages/reports.php"
                        class="nav-link <?= ($pageTitle ?? '') === 'Reports' ? 'active' : '' ?>">
                        <i class="bi bi-graph-up"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </li>
                <?php if (isAdmin()): ?>
                    <li class="nav-item">
                        <a href="<?= APP_URL ?>/pages/clients.php"
                            class="nav-link <?= ($pageTitle ?? '') === 'Clients' ? 'active' : '' ?>">
                            <i class="bi bi-building"></i>
                            <span class="nav-link-text">Clients</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= APP_URL ?>/pages/settings.php"
                        class="nav-link <?= ($pageTitle ?? '') === 'Settings' ? 'active' : '' ?>">
                        <i class="bi bi-gear"></i>
                        <span class="nav-link-text">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <a href="<?= APP_URL ?>/index.php?logout=1" class="nav-link" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
                <span class="nav-link-text">Logout</span>
            </a>

            <div class="user-info">
                <div class="user-avatar">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-details">
                    <div class="user-name"><?= e($_SESSION['user_name'] ?? 'User') ?></div>
                    <div class="user-role"><?= ucfirst($_SESSION['user_role'] ?? 'agent') ?></div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="btn btn-link sidebar-toggle d-lg-none">
                    <i class="bi bi-list fs-4"></i>
                </button>
            </div>

            <div class="topbar-right">
                <div class="topbar-actions">
                    <?php
                    $notifCount = getNotificationCount();
                    $notifications = getRecentNotifications(5);
                    ?>
                    <div class="dropdown">
                        <button class="topbar-icon-btn position-relative" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <?php if ($notifCount > 0): ?>
                                <span class="badge bg-danger notification-badge"><?= $notifCount > 9 ? '9+' : $notifCount ?></span>
                            <?php endif; ?>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end notification-dropdown p-0" style="width: 340px;">
                            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifications</h6>
                                <?php if ($notifCount > 0): ?>
                                    <span class="badge bg-primary"><?= $notifCount ?> new</span>
                                <?php endif; ?>
                            </div>
                            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                <?php if (empty($notifications)): ?>
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-bell-slash d-block mb-2" style="font-size: 1.5rem;"></i>
                                        <small>No recent notifications</small>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($notifications as $notif): ?>
                                        <a href="<?= APP_URL ?>/pages/lead-detail.php?id=<?= $notif['id'] ?>" class="list-group-item list-group-item-action">
                                            <div class="d-flex gap-3">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-sm bg-primary bg-opacity-10" style="width: 36px; height: 36px; font-size: 12px;">
                                                        <?= strtoupper(substr($notif['name'] ?? 'N', 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-medium" style="font-size: 13px;">New lead: <?= e($notif['name'] ?? 'Unknown') ?></p>
                                                    <small class="text-muted"><?= timeAgo($notif['created_at']) ?> · <?= e($notif['utm_source'] ?? 'Direct') ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if ($notifCount > 0): ?>
                                <div class="p-2 border-top text-center">
                                    <a href="<?= APP_URL ?>/pages/leads.php?status=new" class="btn btn-sm btn-link text-decoration-none">View all new leads</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="user-info">
                        <div class="user-avatar">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <?php if ($flash = getFlash()): ?>
            <div class="container-fluid pt-3">
                <div
                    class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : $flash['type'] ?> alert-dismissible fade show">
                    <?= e($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>