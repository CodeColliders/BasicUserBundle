code_colliders_basic_user:
    user_class: <?= $user_class ?> # The fully qualified class for your user
    redirect_route: <?= $redirect_route ?> # Default redirection after login (default: login page)
<?php if($branding): ?>
    branding: # Optional part
        logo_url: <?= $branding['logo_url'] ?> # Picture url to add a logo in login form
        background_url: <?= $branding['background_url'] ?> # Picture url to add a background image in login form page
        form_title: "<?= $branding['form_title'] ?>" # The title of the form (default: Log in)
        catchphrase: "<?= $branding['catchphrase'] ?>" # A catchphrase at the bottom of the form
<?php endif; ?>
