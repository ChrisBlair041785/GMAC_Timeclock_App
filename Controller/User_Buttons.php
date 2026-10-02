
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    // Define the buttons to display for each page
    $buttonsByPage = [
        "Add_Student.php" => ['home','change_password', 'logout'],    
        'ChangePassword.php' => ['home','logout'],
        'Delete_Student.php' => ['home','change_password', 'logout'],
        'Delete_User.php' => ['home','change_password', 'logout'],
        'Edit_Student.php' => ['home','change_password', 'logout'],
        'Edit_User.php' => ['home','change_password', 'logout'],
        'Homepage.php' => ['home','change_password', 'logout'],
        'Log_Report.php' => ['home','change_password', 'logout'],
        'Login.php' => ['new_user'],
        'Registration.php' => [],
        'StudentManagement.php' => ['home','change_password', 'logout'],
        'Timeclock.php' => ['home','change_password', 'logout'],
        'TimeReports.php' => ['home','change_password', 'logout'],
        'UserManagement.php' => ['home','change_password', 'logout'],
    ];
    // Define the properties for each button
    $buttons = [
        'new_user' => [
            'class' => 'btn-primary',
            'label' => 'New User',
            'value' => '../View/Registration.php',
            'onclick' => "location.href='../View/Registration.php'",
        ],
        'change_password' => [
            'class' => 'btn-secondary',
            'label' => 'Change Password',
            'value' => '../View/ChangePassword.php',
            'onclick' => "location.href='../View/ChangePassword.php'",
        ],
        'logout' => [
            'class' => 'btn-primary',
            'label' => 'Logout',
        ],
        'home' => [
            'class' => 'btn-primary',
            'label' => 'Home',
            'value' => '../View/Homepage.php',
            'onclick' => "location.href='../View/Homepage.php'",
        ]
    ];
    ?>

    <div class="btn-group-vertical" role="group" aria-label="User Buttons">
        <?php foreach ($buttonsByPage[$currentPage] ?? [] as $buttonName): ?>
            <?php $button = $buttons[$buttonName]; ?>
            <?php if ($buttonName === 'logout'): ?>
                <form method="post" action="" class="w-100 m-0">
                    <input type="hidden" name="logout" value="1">
                <?php endif; ?>
                    <button type="<?php echo $buttonName === 'logout' ? 'submit' : 'button'; ?>"
                            class="btn <?= htmlspecialchars($button['class'], ENT_QUOTES, 'UTF-8') ?>
                                <?php echo $buttonName === 'logout' ? ' w-100' : ''; ?>"
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