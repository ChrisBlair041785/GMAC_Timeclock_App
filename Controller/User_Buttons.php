
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);

    $buttonsByPage = [
        'Login.php' => ['new_user'],
        'Registration.php' => [],
        'ChangePassword.php' => ['logout'],
        'Homepage.php' => ['change_password', 'logout'],
        'StudentManagement.php' => ['change_password', 'logout'],
        'TimeKeeping.php' => ['change_password', 'logout'],
        'TimeReports.php' => ['change_password', 'logout'],
        'UserManagement.php' => ['change_password', 'logout'],
    ];

    $buttons = [
        'new_user' => [
            'class' => 'btn-primary',
            'label' => 'New User',
            'value' => '../View/Registration.php',
            'onclick' => "location.href='../View/Registration.php'",
        ],
        'change_password' => [
            'class' => 'btn-primary',
            'label' => 'Change Password',
            'value' => '../view/change_password.php',
            'onclick' => "location.href='../view/changepassword.php'",
        ],
        'logout' => [
            'class' => 'btn-secondary',
            'label' => 'Logout',
            'value' => '../View/logout.php',
            'onclick' => "location.href='../View/Logout.php'",
        ],
    ];
    ?>

    <div class="btn-group-vertical" role="group" aria-label="User Buttons">
        <?php foreach ($buttonsByPage[$currentPage] ?? [] as $buttonName): ?>
            <?php $button = $buttons[$buttonName]; ?>
            <button type="button"
                    class="btn <?= htmlspecialchars($button['class'], ENT_QUOTES, 'UTF-8') ?>"
                    name="<?= htmlspecialchars($buttonName, ENT_QUOTES, 'UTF-8') ?>"
                    value="<?= htmlspecialchars($button['value'], ENT_QUOTES, 'UTF-8') ?>"
                    onclick="<?= htmlspecialchars($button['onclick'], ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($button['label'], ENT_QUOTES, 'UTF-8') ?>
            </button>
        <?php endforeach; ?>
        </div>