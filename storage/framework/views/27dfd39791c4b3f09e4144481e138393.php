<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .header-section {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 30px 0;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .product-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .product-image {
            height: 180px;
            object-fit: cover;
            width: 100%;
        }
        .product-info {
            padding: 15px;
        }
        .badge-available {
            background-color: #198754;
        }
        .badge-unavailable {
            background-color: #dc3545;
        }
        .category-badge {
            background-color: #0d6efd;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .search-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        .no-image-placeholder {
            height: 180px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .table-responsive {
            border-radius: 10px;
        }
        .mobile-product-card {
            display: none;
        }
        @media (max-width: 768px) {
            .table-container {
                display: none;
            }
            .mobile-product-card {
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header-section text-center">
            <h1 class="display-5 fw-bold">
                <i class="bi bi-box-seam me-2"></i>Product Management
            </h1>
            <p class="lead">Manage your product inventory with ease</p>
        </div>

        <!-- Action Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0">Products List</h2>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Product
            </a>
        </div>

        <!-- Search Form -->
        <div class="search-container">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" placeholder="Search products by name, description or category..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Search</button>
                </div>
            </form>
        </div>

        <!-- Products Table (Desktop View) -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Availability</th>
                            <th>Category</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-bold"><?php echo e($product->id); ?></td>
                                <td><?php echo e($product->name); ?></td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                        <?php echo e($product->description); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($product->is_available): ?>
                                        <span class="badge badge-available rounded-pill">Yes</span>
                                    <?php else: ?>
                                        <span class="badge badge-unavailable rounded-pill">No</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge category-badge rounded-pill"><?php echo e($product->category); ?></span>
                                </td>
                                <td>
                                    <?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="Product Image" class="img-thumbnail" width="80">
                                    <?php else: ?>
                                        <div class="text-muted small">No image</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Product Cards -->
        <div class="mobile-product-card">
            <div class="row">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="product-card">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="Product Image" class="product-image">
                            <?php else: ?>
                                <div class="no-image-placeholder">
                                    <i class="bi bi-image display-6"></i>
                                </div>
                            <?php endif; ?>
                            <div class="product-info">
                                <h5 class="fw-bold"><?php echo e($product->name); ?></h5>
                                <p class="text-muted small mb-2">
                                    <?php echo e(Str::limit($product->description, 80)); ?>

                                </p>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge category-badge rounded-pill"><?php echo e($product->category); ?></span>
                                    <?php if($product->is_available): ?>
                                        <span class="badge badge-available rounded-pill">Available</span>
                                    <?php else: ?>
                                        <span class="badge badge-unavailable rounded-pill">Unavailable</span>
                                    <?php endif; ?>
                                </div>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="bi bi-pencil me-1"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="flex-fill">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Empty State (if no products) -->
        <?php if(count($products) == 0): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No products found</h3>
                <p class="text-muted">Get started by adding your first product.</p>
                <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Task Project\TaskProject\resources\views/products/index.blade.php ENDPATH**/ ?>