<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 15px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-submit {
            background-color: #0d6efd;
            color: white;
            padding: 10px 30px;
            font-weight: 600;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
        .radio-group {
            padding: 10px 0;
        }
        .form-check-label {
            margin-right: 15px;
        }
        .error-container {
            margin-top: 20px;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: none;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-header">
                <i class="bi bi-plus-circle me-2"></i>Create New Product
            </h2>
            
            <form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data" id="productForm">
                <?php echo csrf_field(); ?>
                
                <!-- Product Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name">
                    <div class="form-text">Enter a descriptive name for your product.</div>
                </div>
                
                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter product description"></textarea>
                </div>
                
                <!-- Availability -->
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_available" name="is_available" value="1">
                        <input type="hidden" name="is_available" value="0">
                        <label class="form-check-label" for="is_available">Product Available</label>
                    </div>
                    <div class="form-text">Toggle to mark this product as available for purchase.</div>
                </div>
                
                <!-- Category -->
                <div class="mb-4">
                    <label class="form-label">Category</label>
                    <div class="radio-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="category" id="electronics" value="Electronics">
                            <label class="form-check-label" for="electronics">
                                <i class="bi bi-phone me-1"></i> Electronics
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="category" id="clothing" value="Clothing">
                            <label class="form-check-label" for="clothing">
                                <i class="bi bi-bag me-1"></i> Clothing
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="category" id="food" value="Food">
                            <label class="form-check-label" for="food">
                                <i class="bi bi-egg-fried me-1"></i> Food
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="image" class="form-label">Product Image</label>
                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                    <div class="form-text">Upload a high-quality image of your product (JPG, PNG, GIF).</div>
                    <img id="imagePreview" class="image-preview mt-2" src="#" alt="Image preview">
                </div>
                
                <!-- Submit Button -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-check-lg me-1"></i> Create Product
                    </button>
                   <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary cancel-btn">
                        <i class="bi bi-arrow-left me-1"></i> Cancel
                    </a>
                </div>
            </form>
            
            <!-- Error Display -->
            <?php if($errors->any()): ?>
                <div class="alert alert-danger error-container mt-4">
                    <h5 class="alert-heading">
                        <i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:
                    </h5>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            const category = document.querySelector('input[name="category"]:checked');
            
            if (!name) {
                alert('Please enter a product name.');
                e.preventDefault();
                return;
            }
            
            if (!description) {
                alert('Please enter a product description.');
                e.preventDefault();
                return;
            }
            
            if (!category) {
                alert('Please select a product category.');
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\Task Project\TaskProject\resources\views/products/create.blade.php ENDPATH**/ ?>