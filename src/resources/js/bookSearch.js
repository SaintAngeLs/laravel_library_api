// $(document).ready(function() {
//     // Load initial book list if no search query is present
//     loadBooks();

//     // Listen for the form submission
//     $('#search-form').on('submit', function(e) {
//         e.preventDefault(); // Prevent the form from submitting traditionally

//         let title = $('#title').val();
//         let publisher = $('#publisher').val();
//         let author = $('#author').val();

//         // Make AJAX request to fetch search results
//         $.ajax({
//             url: '/pages/books/search', // URL for the view controller
//             type: 'GET',
//             data: { title: title, publisher: publisher, author: author },
//             success: function(response) {
//                 updateBooksList(response.data); // Update the books list
//                 updatePagination(response.pagination); // Update the pagination
//             },
//             error: function(xhr) {
//                 console.log("An error occurred:", xhr.responseText);
//             }
//         });
//     });

//     // Function to load books when page loads
//     function loadBooks() {
//         $.ajax({
//             url: '/pages/books/search', // API URL for the initial book list
//             type: 'GET',
//             success: function(response) {
//                 updateBooksList(response.data); // Update the books list
//                 updatePagination(response.pagination); // Update the pagination
//             },
//             error: function(xhr) {
//                 console.log("An error occurred while loading books:", xhr.responseText);
//             }
//         });
//     }

//     // Function to update the books list dynamically
//     function updateBooksList(books) {
//         let booksContainer = $('#books-list');
//         booksContainer.empty(); // Clear the current book list

//         if (books.length === 0) {
//             booksContainer.append('<p>No books found.</p>');
//             return;
//         }

//         books.forEach(function(book) {
//             let bookHTML = `
//                 <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
//                     <h2 class="text-2xl font-semibold mb-4">${book.title}</h2>
//                     <p><strong>Author:</strong> ${book.author}</p>
//                     <p><strong>Published:</strong> ${book.year_of_publication}</p>
//                     <p><strong>Publisher:</strong> ${book.publisher}</p>
//                     <a href="/pages/books/${book.id}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">View Details</a>
//                 </div>
//             `;
//             booksContainer.append(bookHTML);
//         });
//     }

//     // Function to update the pagination using the HTML from Laravel
//     function updatePagination(paginationHtml) {
//         $('#pagination-links').html(paginationHtml); // Replace pagination with the HTML from Laravel
//     }

//     // Pagination click handling
//     $(document).on('click', '#pagination-links a', function(e) {
//         e.preventDefault();
//         let url = $(this).attr('href');

//         // Fetch new page data using AJAX
//         $.ajax({
//             url: url,
//             success: function(response) {
//                 updateBooksList(response.data);
//                 updatePagination(response.pagination);
//             },
//             error: function(xhr) {
//                 console.log("An error occurred:", xhr.responseText);
//             }
//         });
//     });
// });
