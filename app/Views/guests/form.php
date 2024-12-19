<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($guest) ? 'Edit Guest' : 'Add Guest' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4"><?= isset($guest) ? 'Edit Guest' : 'Add Guest' ?></h1>
    <?php if (session()->get('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->get('errors') as $field => $message): ?>
                    <li><strong><?= ucfirst($field) ?>:</strong> <?= esc($message) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="<?= isset($guest) ?  base_url("/guests/update/{$guest->id}") :  base_url('/guests/store') ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= isset($guest) ? $guest->name : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= isset($guest) ? $guest->email : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($guest) ? $guest->phone : '' ?>">
        </div>
        <button type="submit" class="btn btn-success"><?= isset($guest) ? 'Update' : 'Add' ?></button>
        <a href=<?=base_url("/guests") ?> class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
