<!doctype html>
<html>
    <head>
        <title>Categories List</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 30px;
                background: #f8f9fa;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .header h1 {
                margin: 0;
            }

            .add-btn {
                background: #198754;
                color: white;
                padding: 10px 15px;
                text-decoration: none;
                border-radius: 5px;
            }

            .add-btn:hover {
                background: #157347;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background: white;
            }

            th,
            td {
                padding: 12px;
                border: 1px solid #ddd;
                text-align: center;
            }

            th {
                background: #f2f2f2;
            }

            .product-image {
                width: 70px;
                height: 70px;
                object-fit: cover;
                border-radius: 5px;
            }

            .status-active {
                color: green;
                font-weight: bold;
            }

            .status-inactive {
                color: red;
                font-weight: bold;
            }

            .action-link {
                font-size: 18px;
                text-decoration: none;
                margin: 0 5px;
            }

            .edit {
                color: blue;
            }


            .delete {
                color: #dc3545;
                border: none;
                background: none;
                cursor: pointer;
                font-size: 18px;
                margin: 0 5px;
            }

        
            .success-toast {
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translate(-50%);
                background: #198754;
                color: white;
                padding: 14px 25px;
                border-radius: 6px;

                display: none;
                align-items: center;
                gap: 10px;

                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 9999;
            }

            .success-toast i {
                font-size: 20px;
            }
            .loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10000;
            }

            .spinner {
                width: 40px;
                height: 40px;
                border: 4px solid #ddd;
                border-top: 4px solid #198754;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
            }

            @keyframes spin {
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>

    </head>
<body>
    <div class="header">
        <h1> Categories List</h1>
                <button type="button" class="add-btn" id="addcategory"><i class="bi bi-person-plus"></i>Add Category</button>
    </div>
    <div class="form-container">    
        <table>
            <thead>
                <tr>
                    <th> Name</th>
                    <th style="width: 30%">Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               @forelse ($categories as $category )
                      <tr id="category-{{ $category->id }}">
                        <td>{{$category->name}}</td>
                        <td>
                            <span class="{{ $category->status ? 'status-active' : 'status-inactive' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td>
                            <button type="button" class="action-link edit editcategory"  data-id="{{ $category->id }}"title="Edit">  <i class="bi bi-pencil"></i></button>
                            <button type="button" class="delete deletecategory" data-id="{{ $category->id }}"title="Delete"> <i class="bi bi-trash"></i></button> 
                        </td>  
                    </tr>  
                @empty

                    <tr id="nocategorys">
                        <td colspan="3"style="text-align:center;">
                            No category found.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
         <div id="categoryModal" style="display:none;">
            <div id="categoryFormContainer"></div>
        </div>
    </div>
        <div id="successToast" class="success-toast">
            <i class="bi bi-check-circle-fill"></i>
            <span id="toastMessage"></span>
        </div>
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>
<script>

$(document).ready(function () {

// CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  
    function showLoader() {
        $('#loader').show();
    }
    function hideLoader() {
        $('#loader').hide();
    }

// ADD category 
    $('#addcategory').click(function () {
        showLoader();
        $.ajax({
            url: "{{ route('categories.create') }}",
            type: "GET",
            success: function (response) {
                $('#categoryFormContainer').html(response);
                $('#categoryModal').show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load category form.');
            },
            complete: function () {
                hideLoader();
            }
        });
    });


   
// SAVE category
    $(document).on('submit', '#categoryForm', function (e) {
        e.preventDefault();
        let form = this;
        showLoader();

        $.ajax({
            url: $(form).attr('action'),
            type: "POST",
            data: $(form).serialize(),
            headers: {
                'Accept': 'application/json'
            },
            success: function (response) {
                console.log(response);
                $('#categoryModal').hide();
                $('#categoryFormContainer').html('');
                $('#nocategorys').remove();
                let category = response.category;
            
                $('tbody').append(`
                    <tr id="category-${category.id}">
                        <td>${category.name}</td>
                        <td>
                            ${category.status == 1
                                ? '<span class="status-active">Active</span>'
                                : '<span class="status-inactive">Inactive</span>'
                            }
                        </td>

                        <td>
                            <button type="button"
                                    class="action-link edit editcategory"
                                    data-id="{{ $category->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <button type="button"
                                    class="delete deletecategory"
                                    data-id="{{ $category->id }}"
                                    title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);

                showToast(response.message);

            },
            error: function (xhr) {
                console.log(xhr.responseText);
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');
                    $.each(errors, function (field, messages) {
                        $('#' + field + 'Error').text(messages[0]);
                    });
                } else {
                    alert('Unable to save category.');
                }
            },
            complete: function () {
                hideLoader();
            }
        });
    });


// EDIT category 
$(document).on('submit', '#categoryEditForm', function(e) {
    e.preventDefault();
    let form = this;
    showLoader();
    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        headers: {
            'Accept': 'application/json'},
        success: function(response) {
            let category = response.category;
            let row = $('#category-' + category.id);
            // Update name
            row.find('td:eq(0)').text(category.name);
            // Update status
            if (category.status == 1) {

                row.find('td:eq(1)').html(
                    '<span class="status-active">Active</span>'
                );
            } else {

                row.find('td:eq(1)').html(
                    '<span class="status-inactive">Inactive</span>'
                );
            }
            $('#categoryModal').hide();
            $('#categoryFormContainer').html('');
            showToast(response.message);
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.text-danger').text('');
                $.each(errors, function(field, messages) {
                    $('#edit_' + field + 'Error')
                        .text(messages[0]);
                });
            } else {
                alert('Unable to update category.');
            }
        },
        complete: function() {
            hideLoader();
        }
    });

});


    // EDIT category - OPEN FORM

    $(document).on('click', '.editcategory', function () {

        let id = $(this).data('id');
        showLoader();
        $.ajax({
            url: "{{ url('categories') }}/" + id + "/edit",
            type: "GET",
            success: function (response) {
                $('#categoryFormContainer').html(response);
                $('#categoryModal').show();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Unable to load category edit form.');
            },
            complete: function () {
                hideLoader();
            }
        });

    });

    $(document).on('click', '#cancelEditCategory', function() {

        $('#categoryModal').hide();
        $('#categoryFormContainer').html('');

    });

    // CANCEL category

    $(document).on('click', '#cancelCategory', function () {
        
        $('#categoryForm')[0].reset();
        $('.text-danger').text('');
        $('#categoryModal').hide();
        $('#categoryFormContainer').html('');

    });

    function showToast(message) {
        $('#toastMessage').text(message);
        $('#successToast').css('display', 'flex').hide().fadeIn();

        setTimeout(function () {
            $('#successToast').fadeOut();
        }, 3000);
    }

// DELETE category
    $(document).on('click', '.deletecategory', function () {

        let id = $(this).data('id');

        if (!confirm('Are you sure you want to delete this category?')) {
            return;
        }

        showLoader();

        $.ajax({
            url: "{{ url('categories') }}/" + id,
            type: "DELETE",
            headers: {
                'Accept': 'application/json'
            },

            success: function(response) {

                $('#category-' + id).remove();

                showToast(response.message);

                if ($('tbody tr[id^="category-"]').length === 0) {
                    $('tbody').html(`
                        <tr id="nocategorys">
                            <td colspan="3" style="text-align:center;">
                                No category found.
                            </td>
                        </tr>
                    `);
                }
            },

            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Unable to delete category.');
            },

            complete: function() {
                hideLoader();
            }
        });
    });
  
});    

</script>
</body>
</html> 