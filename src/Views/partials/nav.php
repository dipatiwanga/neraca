<?php
use App\Helpers\Menu;
use Core\Session;

Session::start();
$role = Session::get('user_role', 'guest');
$menus = Menu::getMenuByRole($role);
$currentUri = $_SERVER['REQUEST_URI'];
?>

<nav style="background: #333; color: #fff; padding: 12px; text-align: center; margin-bottom: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
    <?php foreach ($menus as $menu): ?>
        <?php 
            $isActive = (strpos($currentUri, $menu['active']) === 0 && $menu['active'] !== '/') || ($currentUri === $menu['active']);
            $style = "color: #fff; text-decoration: none; margin: 0 15px; font-size: 0.95em;";
            if ($isActive) $style .= " border-bottom: 2px solid #fff; padding-bottom: 3px; font-weight: bold;";
            if (isset($menu['highlight']) && $menu['highlight']) $style .= " color: #ffc107;";
        ?>
        <a href="<?= $menu['url'] ?>" style="<?= $style ?>">
            <?= $menu['title'] ?>
        </a>
    <?php endforeach; ?>
    
    <span style="margin-left: 40px; font-size: 0.85em; color: #aaa; border-left: 1px solid #555; padding-left: 20px;">
        User: <strong style="color: #eee;"><?= Session::get('user_name', 'Guest') ?></strong> 
        (<span style="font-style: italic;"><?= ucfirst($role) ?></span>)
    </span>
    
    <a href="/logout" style="background: #d9534f; color: #fff; text-decoration: none; padding: 6px 15px; border-radius: 4px; margin-left: 20px; font-size: 0.85em; font-weight: bold;">
        Logout
    </a>
</nav>
