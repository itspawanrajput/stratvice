<?php
/**
 * Lead CRM - Client Management (Admin Only)
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();
requireRole('admin');

$pageTitle = 'Clients';
$db = db();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $action = $_POST['action'] ?? '';
    
    if ($action === 'create_client') {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $businessName = sanitize($_POST['business_name']);
        $webhookToken = generateWebhookToken();
        
        $clientId = $db->insert('clients', [
            'name' => $name,
            'email' => $email,
            'business_name' => $businessName,
            'webhook_token' => $webhookToken
        ]);
        
        if (!empty($_POST['create_user'])) {
            $username = sanitize($_POST['username']);
            $password = $_POST['password'];
            createUser([
                'client_id' => $clientId,
                'username' => $username,
                'password' => $password,
                'name' => $name,
                'email' => $email,
                'role' => 'manager'
            ]);
        }
        
        setFlash('success', 'Client created successfully!');
        redirect(APP_URL . '/pages/clients.php');
    }
    
    if ($action === 'regenerate_token') {
        $clientId = (int) $_POST['client_id'];
        $newToken = generateWebhookToken();
        $db->update('clients', ['webhook_token' => $newToken], 'id = :id', ['id' => $clientId]);
        setFlash('success', 'Webhook token regenerated');
        redirect(APP_URL . '/pages/clients.php');
    }
    
    if ($action === 'delete_client') {
        $clientId = (int) $_POST['client_id'];
        // Cascade: delete users associated with this client
        $db->delete('users', 'client_id = :client_id', ['client_id' => $clientId]);
        $db->delete('clients', 'id = :id', ['id' => $clientId]);
        setFlash('success', 'Client and associated users deleted');
        redirect(APP_URL . '/pages/clients.php');
    }
}

$clients = getClients();

// Get lead counts per client
$clientStats = [];
foreach ($clients as $client) {
    $clientStats[$client['id']] = $db->fetch(
        "SELECT COUNT(*) as total, 
                SUM(CASE WHEN status = 'new' THEN 1 ELSE 0 END) as new,
                SUM(CASE WHEN status = 'won' THEN 1 ELSE 0 END) as won
         FROM leads WHERE client_id = :client_id",
        ['client_id' => $client['id']]
    );
}

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Clients</h2>
            <p class="text-muted mb-0">Manage client accounts and webhook tokens</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
            <i class="bi bi-plus-lg me-1"></i>Add Client
        </button>
    </div>
    
    <div class="row g-4">
        <?php foreach ($clients as $client): ?>
            <?php $stats = $clientStats[$client['id']] ?? ['total' => 0, 'new' => 0, 'won' => 0]; ?>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="mb-1"><?= e($client['name']) ?></h5>
                                <small class="text-muted"><?= e($client['business_name']) ?></small>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="regenerate_token">
                                            <input type="hidden" name="client_id" value="<?= $client['id'] ?>">
                                            <?= csrfField() ?>
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-arrow-repeat me-2"></i>Regenerate Token
                                            </button>
                                        </form>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure? This will delete all leads for this client.')">
                                            <input type="hidden" name="action" value="delete_client">
                                            <input type="hidden" name="client_id" value="<?= $client['id'] ?>">
                                            <?= csrfField() ?>
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Delete Client
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="row text-center g-2 mb-3">
                            <div class="col-4">
                                <div class="p-2 rounded" style="background: rgba(99, 102, 241, 0.1);">
                                    <div class="fw-bold"><?= number_format($stats['total'] ?? 0) ?></div>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded" style="background: rgba(16, 185, 129, 0.1);">
                                    <div class="fw-bold"><?= number_format($stats['new'] ?? 0) ?></div>
                                    <small class="text-muted">New</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded" style="background: rgba(245, 158, 11, 0.1);">
                                    <div class="fw-bold"><?= number_format($stats['won'] ?? 0) ?></div>
                                    <small class="text-muted">Won</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Webhook URL -->
                        <div class="detail-label">Webhook URL</div>
                        <div class="input-group input-group-sm mb-3">
                            <input type="text" class="form-control" value="<?= APP_URL ?>/api/webhook.php?token=<?= e($client['webhook_token']) ?>" readonly id="webhook-<?= $client['id'] ?>">
                            <button class="btn btn-outline-secondary" data-copy="<?= APP_URL ?>/api/webhook.php?token=<?= e($client['webhook_token']) ?>">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                        
                        <div class="d-flex justify-content-between text-muted small">
                            <span><i class="bi bi-envelope me-1"></i><?= e($client['email']) ?></span>
                            <span>Created <?= formatDate($client['created_at']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (empty($clients)): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-building fs-1 text-muted d-block mb-3"></i>
                        <h5>No Clients Yet</h5>
                        <p class="text-muted mb-3">Create your first client to start receiving leads.</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
                            <i class="bi bi-plus-lg me-1"></i>Add Your First Client
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Create Client Modal -->
<div class="modal fade" id="createClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="action" value="create_client">
                <?= csrfField() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add New Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Contact Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Name</label>
                        <input type="text" name="business_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    
                    <hr>
                    
                    <div class="form-check mb-3">
                        <input type="checkbox" name="create_user" value="1" class="form-check-input" id="createUser">
                        <label class="form-check-label" for="createUser">Create login account for this client</label>
                    </div>
                    
                    <div id="userFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" minlength="8">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Client</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('createUser').addEventListener('change', function() {
    document.getElementById('userFields').style.display = this.checked ? 'block' : 'none';
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
