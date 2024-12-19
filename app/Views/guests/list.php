<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guests List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Guests List</h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <a href="<?= base_url('guests/create') ?>" class="btn btn-primary mb-3">Add Guest</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guests as $guest): ?>
                <tr>
                    <td><?= $guest->id ?></td>
                    <td><?= $guest->name ?></td>
                    <td><?= $guest->email ?></td>
                    <td><?= $guest->phone ?></td>
                    <td>
                        <a href=<?= base_url('guests/edit/').$guest->id ?> class="btn btn-warning btn-sm">Edit</a>
                        <a href=<?= base_url('guests/delete/').$guest->id ?> class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this guest?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
