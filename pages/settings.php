<?php
/**
 * Lead CRM - Settings
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();

$pageTitle = 'Settings';
$db = db();

$userId = getCurrentUserId();
$user = $db->fetch("SELECT * FROM users WHERE id = :id", ['id' => $userId]);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_profile') {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        
        $db->update('users', [
            'name' => $name,
            'email' => $email
        ], 'id = :id', ['id' => $userId]);
        
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        setFlash('success', 'Profile updated successfully');
        redirect(APP_URL . '/pages/settings.php');
    }
    
    if ($action === 'change_password') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        
        if (!password_verify($currentPassword, $user['password_hash'])) {
            setFlash('error', 'Current password is incorrect');
        } elseif ($newPassword !== $confirmPassword) {
            setFlash('error', 'New passwords do not match');
        } elseif (strlen($newPassword) < PASSWORD_MIN_LENGTH) {
            setFlash('error', 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters');
        } else {
            $db->update('users', [
                'password_hash' => hashPassword($newPassword)
            ], 'id = :id', ['id' => $userId]);
            setFlash('success', 'Password changed successfully');
        }
        redirect(APP_URL . '/pages/settings.php');
    }
    
    if ($action === 'create_user' && isAdmin()) {
        $data = [
            'client_id' => getCurrentClientId(),
            'username' => sanitize($_POST['username']),
            'password' => $_POST['password'],
            'name' => sanitize($_POST['user_name']),
            'email' => sanitize($_POST['user_email']),
            'role' => sanitize($_POST['role'])
        ];
        
        try {
            createUser($data);
            setFlash('success', 'User created successfully');
        } catch (Exception $e) {
            setFlash('error', 'Failed to create user. Username may already exist.');
        }
        redirect(APP_URL . '/pages/settings.php');
    }
    
    if ($action === 'delete_user' && isAdmin()) {
        $deleteUserId = (int) $_POST['user_id'];
        if ($deleteUserId !== $userId) {
            $db->delete('users', 'id = :id', ['id' => $deleteUserId]);
            setFlash('success', 'User deleted');
        }
        redirect(APP_URL . '/pages/settings.php');
    }
    
    if ($action === 'toggle_user' && isAdmin()) {
        $toggleUserId = (int) $_POST['user_id'];
        $isActive = (int) $_POST['is_active'];
        $db->update('users', ['is_active' => $isActive], 'id = :id', ['id' => $toggleUserId]);
        setFlash('success', 'User status updated');
        redirect(APP_URL . '/pages/settings.php');
    }
}

$users = getUsers();

// Get webhook info for current client
$client = null;
if (getCurrentClientId()) {
    $client = getClient(getCurrentClientId());
}

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="mb-1">Settings</h2>
        <p class="text-muted mb-0">Manage your account and preferences</p>
    </div>
    
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Profile Settings -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person me-2"></i>Profile Settings</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="update_profile">
                        <?= csrfField() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?= e($user['name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?= e($user['email']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" value="<?= e($user['username']) ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" value="<?= ucfirst($user['role']) ?>" disabled>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg me-1"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Change Password -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lock me-2"></i>Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="change_password">
                        <?= csrfField() ?>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" required minlength="8">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="bi bi-key me-1"></i>Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- User Management (Admin only) -->
            <?php if (isAdmin()): ?>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>User Management</h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-plus-lg me-1"></i>Add User
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Last Login</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold"><?= e($u['name']) ?></div>
                                                    <small class="text-muted"><?= e($u['email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= e($u['username']) ?></td>
                                        <td><span class="badge bg-secondary"><?= ucfirst($u['role']) ?></span></td>
                                        <td><?= $u['last_login'] ? formatDateTime($u['last_login']) : '<span class="text-muted">Never</span>' ?></td>
                                        <td>
                                            <?php if ($u['is_active']): ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($u['id'] !== $userId): ?>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="toggle_user">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <input type="hidden" name="is_active" value="<?= $u['is_active'] ? 0 : 1 ?>">
                                                    <?= csrfField() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        <?= $u['is_active'] ? 'Disable' : 'Enable' ?>
                                                    </button>
                                                </form>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                                    <?= csrfField() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted">You</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Webhook Info -->
            <?php if ($client): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Webhook</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Use this URL in your Lead Gravity plugin settings to receive leads automatically.</p>
                    
                    <div class="detail-label">Webhook URL</div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-sm" value="<?= APP_URL ?>/api/webhook.php?token=<?= e($client['webhook_token']) ?>" readonly>
                        <button class="btn btn-outline-secondary btn-sm" data-copy="<?= APP_URL ?>/api/webhook.php?token=<?= e($client['webhook_token']) ?>">
                            <i class="bi bi-clipboard"></i>
                        </button>
                    </div>
                    
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        Keep this URL secret. Anyone with this URL can send leads to your account.
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Account Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Account Info</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Account Created</div>
                        <div class="detail-value"><?= formatDateTime($user['created_at']) ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="detail-label">Last Login</div>
                        <div class="detail-value"><?= $user['last_login'] ? formatDateTime($user['last_login']) : 'N/A' ?></div>
                    </div>
                    <div>
                        <div class="detail-label">App Version</div>
                        <div class="detail-value"><?= APP_VERSION ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-link me-2"></i>Quick Links</h5>
                </div>
                <div class="card-body">
                    <a href="<?= APP_URL ?>/pages/leads.php?export=csv" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-download me-2"></i>Export All Leads
                    </a>
                    <a href="<?= APP_URL ?>/index.php?logout=1" class="btn btn-outline-danger w-100">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<?php if (isAdmin()): ?>
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="action" value="create_user">
                <?= csrfField() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="user_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="user_email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username *</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="agent">Agent</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
