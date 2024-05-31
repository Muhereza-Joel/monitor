<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <div class="d-flex">
            <nav class="w-50">
                <h1>Books</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                    <li class="breadcrumb-item active">Books</li>
                </ol>
            </nav>
            <div class="buttons-container align-self-center w-50 text-end">
            <a href="/<?php echo e($appName); ?>/books/" title="List View">
                <div class="icon" style="font-size: 35px;">
                    <i class="bi bi-list"></i>
        
                </div>
        
            </a>
                <?php if($role == 'Administrator'): ?>
        
        
                <?php endif; ?>
            </div>

        </div>
    </div><!-- End Page Title -->
    <section class="section dashboard">
        <div class="row g-4" id="booksList">
            <!-- book cards will be dynamically added here -->
        </div>

        <!-- Pagination Links -->
        <div id="paginationLinks" class="col-12 mt-4 text-center">
            <!-- Pagination links will be added dynamically here -->
        </div>
       
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    const booksData = <?php echo json_encode($books); ?>;

    const booksPerPage = 8; // Number of books per page
    let currentPage = 1;

    function displayBooks(page) {
        const startIndex = (page - 1) * booksPerPage;
        const endIndex = startIndex + booksPerPage;
        const books = booksData.slice(startIndex, endIndex);

        const booksList = document.getElementById('booksList');
        booksList.innerHTML = '';

        books.forEach(book => {
            const card = `
                    <div class="col-sm-3">
                        <a href="/<?php echo e($appName); ?>/books/view/?id=${book.id}" class="card" style="text-decoration: none; color: inherit;">
                            <!-- Your card content here -->
                            <div style="width: 100%; height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; overflow: hidden;">
                                <img src="${book.cover}" class="card-img-top" alt="book image" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${book.title}</h5>
                                <h6 class="span" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>Author: </strong>${book.author}</h6>
                                <h6 class="span" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>Edition: </strong>${book.edition}</h6>
                                <h6 class="badge bg-success" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${book.total} in stock</h6>
                                <h6 class="badge bg-secondary" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${book.borrowed} borrowed</h6>
                            </div>
                        </a>
                       
                    </div>
                `;
            booksList.innerHTML += card;
        });
    }

    function displayPagination() {

        const totalPages = Math.ceil(booksData.length / booksPerPage);
        const paginationLinks = document.getElementById('paginationLinks');
        paginationLinks.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const link = `
                    <a href="#page=${i}" onclick="changePage(${i})" class="btn btn-primary btn-sm">${i}</a>
                `;
            paginationLinks.innerHTML += link;
        }
    }

    // Initial display
    displayBooks(currentPage);
    displayPagination();

    function changePage(page) {
        currentPage = page;
        displayBooks(currentPage);
    }
</script>