<?php
/**
 * Lead CRM - Lead Detail
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireAuth();

$leadId = (int) ($_GET['id'] ?? 0);

if (!$leadId) {
    setFlash('error', 'Invalid lead ID');
    redirect(APP_URL . '/pages/leads.php');
}

$lead = getLead($leadId);

if (!$lead) {
    setFlash('error', 'Lead not found');
    redirect(APP_URL . '/pages/leads.php');
}

$pageTitle = 'Lead #' . $leadId;

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrf();
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_status') {
        $newStatus = sanitize($_POST['status']);
        db()->update('leads', ['status' => $newStatus], 'id = :id', ['id' => $leadId]);
        addLeadActivity($leadId, 'status_changed', "Status changed to {$newStatus}");
        setFlash('success', 'Status updated successfully');
        redirect(APP_URL . '/pages/lead-detail.php?id=' . $leadId);
    }
    
    if ($action === 'update_quality') {
        $quality = (int) $_POST['quality_score'];
        db()->update('leads', ['quality_score' => $quality], 'id = :id', ['id' => $leadId]);
        addLeadActivity($leadId, 'quality_rated', "Quality rated {$quality}/10");
        setFlash('success', 'Quality score updated');
        redirect(APP_URL . '/pages/lead-detail.php?id=' . $leadId);
    }
    
    if ($action === 'assign_lead') {
        $assignTo = !empty($_POST['assigned_to']) ? (int) $_POST['assigned_to'] : null;
        db()->update('leads', ['assigned_to' => $assignTo], 'id = :id', ['id' => $leadId]);
        $assignName = $assignTo ? 'user #' . $assignTo : 'unassigned';
        addLeadActivity($leadId, 'lead_assigned', "Lead assigned to {$assignName}");
        setFlash('success', 'Lead assignment updated');
        redirect(APP_URL . '/pages/lead-detail.php?id=' . $leadId);
    }
    
    if ($action === 'add_note') {
        $notes = sanitize($_POST['notes']);
        db()->update('leads', ['notes' => $notes], 'id = :id', ['id' => $leadId]);
        addLeadActivity($leadId, 'note_added', 'Notes updated');
        setFlash('success', 'Notes saved');
        redirect(APP_URL . '/pages/lead-detail.php?id=' . $leadId);
    }
    
    if ($action === 'mark_spam') {
        db()->update('leads', ['is_spam' => 1, 'status' => 'lost'], 'id = :id', ['id' => $leadId]);
        addLeadActivity($leadId, 'marked_spam', 'Marked as spam/fake');
        setFlash('success', 'Lead marked as spam');
        redirect(APP_URL . '/pages/leads.php');
    }
}

$activities = getLeadActivities($leadId);
$users = getUsers();

include __DIR__ . '/../includes/header.php';
?>

<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="leads.php">Leads</a></li>
            <li class="breadcrumb-item active">Lead #<?= $leadId ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Lead Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-3" style="width: 60px; height: 60px; font-size: 24px;">
                                <?= strtoupper(substr($lead['name'] ?? 'N', 0, 1)) ?>
                            </div>
                            <div>
                                <h3 class="mb-1"><?= e($lead['name'] ?? 'Unknown') ?></h3>
                                <p class="text-muted mb-0">
                                    <?php if (!empty($lead['form_name'])): ?>
                                        <i class="bi bi-file-text me-1"></i><?= e($lead['form_name']) ?> •
                                    <?php endif; ?>
                                    Lead #<?= $leadId ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <?php if (!empty($lead['phone'])): ?>
                                <a href="tel:<?= e($lead['phone']) ?>" class="btn btn-success">
                                    <i class="bi bi-telephone me-1"></i>Call
                                </a>
                                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $lead['phone']) ?>" target="_blank" class="btn btn-outline-success">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            <?php endif; ?>
                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#spamModal">
                                <i class="bi bi-flag"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Status & Quality -->
                    <div class="row g-3">
                        <div class="col-md-4">
                            <form method="POST" class="d-flex flex-column">
                                <input type="hidden" name="action" value="update_status">
                                <?= csrfField() ?>
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>New</option>
                                    <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
                                    <option value="qualified" <?= $lead['status'] === 'qualified' ? 'selected' : '' ?>>Qualified</option>
                                    <option value="won" <?= $lead['status'] === 'won' ? 'selected' : '' ?>>Won</option>
                                    <option value="lost" <?= $lead['status'] === 'lost' ? 'selected' : '' ?>>Lost</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" class="d-flex flex-column">
                                <input type="hidden" name="action" value="update_quality">
                                <?= csrfField() ?>
                                <label class="form-label">Quality Score</label>
                                <select name="quality_score" class="form-select" onchange="this.form.submit()">
                                    <option value="0" <?= $lead['quality_score'] == 0 ? 'selected' : '' ?>>Not Rated</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>" <?= $lead['quality_score'] == $i ? 'selected' : '' ?>><?= $i ?>/10</option>
                                    <?php endfor; ?>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" class="d-flex flex-column">
                                <input type="hidden" name="action" value="assign_lead">
                                <?= csrfField() ?>
                                <label class="form-label">Assign To</label>
                                <select name="assigned_to" class="form-select" onchange="this.form.submit()">
                                    <option value="">Unassigned</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= $lead['assigned_to'] == $user['id'] ? 'selected' : '' ?>>
                                            <?= e($user['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">
                                <?php if (!empty($lead['phone'])): ?>
                                    <a href="tel:<?= e($lead['phone']) ?>" class="text-decoration-none">
                                        <?= e($lead['phone']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Not provided</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value">
                                <?php if (!empty($lead['email'])): ?>
                                    <a href="mailto:<?= e($lead['email']) ?>" class="text-decoration-none">
                                        <?= e($lead['email']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Not provided</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Message</div>
                            <div class="detail-value">
                                <?= !empty($lead['message']) ? nl2br(e($lead['message'])) : '<span class="text-muted">No message</span>' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Attribution Data -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Attribution Data</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="detail-label">Source</div>
                            <div class="detail-value"><?= e($lead['utm_source']) ?: '<span class="text-muted">Direct</span>' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Medium</div>
                            <div class="detail-value"><?= e($lead['utm_medium']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Campaign</div>
                            <div class="detail-value"><?= e($lead['utm_campaign']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Content</div>
                            <div class="detail-value"><?= e($lead['utm_content']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Term / Keyword</div>
                            <div class="detail-value"><?= e($lead['utm_term']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">GCLID (Google Ads)</div>
                            <div class="detail-value small"><?= e($lead['gclid']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">FBCLID (Facebook)</div>
                            <div class="detail-value small"><?= e($lead['fbclid']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Landing Page</div>
                            <div class="detail-value small">
                                <?php if (!empty($lead['landing_page'])): ?>
                                    <a href="<?= e($lead['landing_page']) ?>" target="_blank" class="text-decoration-none">
                                        <?= e($lead['landing_page']) ?>
                                        <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-label">Referrer</div>
                            <div class="detail-value small"><?= e($lead['referrer_url']) ?: '<span class="text-muted">-</span>' ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Visitor Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-laptop me-2"></i>Visitor Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="detail-label">IP Address</div>
                            <div class="detail-value"><?= e($lead['ip_address']) ?: '-' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">City</div>
                            <div class="detail-value"><?= e($lead['city']) ?: '-' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Country</div>
                            <div class="detail-value"><?= e($lead['country']) ?: '-' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Device</div>
                            <div class="detail-value"><?= e($lead['device_type']) ?: '-' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Browser</div>
                            <div class="detail-value"><?= e($lead['browser']) ?: '-' ?></div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">OS</div>
                            <div class="detail-value"><?= e($lead['os']) ?: '-' ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notes -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-sticky me-2"></i>Notes</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add_note">
                        <?= csrfField() ?>
                        <textarea name="notes" class="form-control mb-3" rows="4" placeholder="Add notes about this lead..."><?= e($lead['notes']) ?></textarea>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Save Notes
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Activity Timeline -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Activity</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($activities)): ?>
                        <p class="text-muted text-center py-4">No activity recorded yet</p>
                    <?php else: ?>
                        <div class="activity-timeline">
                            <?php foreach ($activities as $activity): ?>
                                <div class="activity-item">
                                    <div class="fw-semibold"><?= ucwords(str_replace('_', ' ', $activity['action'])) ?></div>
                                    <?php if (!empty($activity['notes'])): ?>
                                        <div class="text-muted small"><?= e($activity['notes']) ?></div>
                                    <?php endif; ?>
                                    <div class="text-muted small mt-1">
                                        <?= $activity['user_name'] ?? 'System' ?> • <?= timeAgo($activity['created_at']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Timestamps -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Timestamps</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Lead Date</div>
                        <div class="detail-value"><?= formatDateTime($lead['lead_timestamp']) ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="detail-label">Created At</div>
                        <div class="detail-value"><?= formatDateTime($lead['created_at']) ?></div>
                    </div>
                    <div>
                        <div class="detail-label">Last Updated</div>
                        <div class="detail-value"><?= formatDateTime($lead['updated_at']) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Spam Modal -->
<div class="modal fade" id="spamModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mark as Spam/Fake</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to mark this lead as spam or fake? This will:</p>
                <ul>
                    <li>Flag the lead as spam</li>
                    <li>Change status to "Lost"</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" class="d-inline">
                    <input type="hidden" name="action" value="mark_spam">
                    <?= csrfField() ?>
                    <button type="submit" class="btn btn-danger">Mark as Spam</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
