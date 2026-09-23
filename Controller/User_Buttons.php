
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
            'value' => '../View/ChangePassword.php',
            'onclick' => "location.href='../View/ChangePassword.php'",
        ],
        'logout' => [
            'class' => 'btn-secondary',
            'label' => 'Logout',
        ],
    ];
    ?>

    <div class="btn-group-vertical" role="group" aria-label="User Buttons">
        <?php foreach ($buttonsByPage[$currentPage] ?? [] as $buttonName): ?>
            <?php $button = $buttons[$buttonName]; ?>
            <?php if ($buttonName === 'logout'): ?>
                <form method="post" action="">
                <input type="hidden" name="logout" value="1">
            <?php endif; ?>
            <button type="<?php echo $buttonName === 'logout' ? 'submit' : 'button'; ?>"
                    class="btn <?= htmlspecialchars($button['class'], ENT_QUOTES, 'UTF-8') ?>"
                    name="<?= htmlspecialchars($buttonName, ENT_QUOTES, 'UTF-8') ?>"
                    <?php if ($buttonName !== 'logout'): ?>
                    value="<?= htmlspecialchars($button['value'], ENT_QUOTES, 'UTF-8') ?>"
                    onclick="<?= htmlspecialchars($button['onclick'], ENT_QUOTES, 'UTF-8') ?>"
                    <?php endif; ?>>
                    <?= htmlspecialchars($button['label'], ENT_QUOTES, 'UTF-8') ?>
            </button>
            <?php if ($buttonName === 'logout'): ?>
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>