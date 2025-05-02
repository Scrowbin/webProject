
document.addEventListener('DOMContentLoaded', () => {
    let commentForm = document.getElementById('comment-form');
    let isLoggedIn = commentForm?.dataset.loggedIn === "true"; // Safely access logged-in flag
    const commentsID = commentForm?.dataset.sectionId;
    let toastElement = document.getElementById('loginToast');
    let toast = new bootstrap.Toast(toastElement);

    // Handle rating dropdown
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();

            if (!isLoggedIn) {
                toast.show(); // Show toast if not logged in
                return;
            }
            commentForm.submit();
        });
    });

    // Prevent rating form submission if not logged in
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!isLoggedIn) {
                toast.show();
                return;
            }

            const formData = new FormData(commentForm);

            fetch('../controller/submitComment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text); });
                }
                return response.text();
            })
            .then(() => {
                commentForm.reset();
                document.getElementById('replyID').value = "0";
                document.getElementById('reply-preview').innerHTML = '';
                fetchComments(currentPage); // Refresh comment list
            })
            .catch(error => {
                alert(error.message || "Failed to submit comment.");
            });
        });
    }

    let currentPage = 1;
    const commentsPerPage = 5;

    function fetchComments(page = 1) {
        fetch(`fetchComments.php?commentsID=${commentsID}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                console.log("Loaded data:", data);

                const commentContainer = document.getElementById('comments-container');
                const pagination = document.getElementById('pagination');
                commentContainer.innerHTML = '';
                pagination.innerHTML = '';

                let i = 1;
                data.comments.forEach(comment => {
                    const div = document.createElement('div');
                    div.className = "comment rounded p-3 mb-4";

                    // Quoted comment block (if ReplyID is not 0)
                    const quoteHTML = (comment.ReplyID !== 0 && comment.QuoteContent) ? `
                        <div class="quote">
                            <div class="quote-author">${comment.QuoteUsername} said:</div>
                            <div>${comment.QuoteContent}</div>
                        </div>
                    ` : '';

                    div.innerHTML = `
                        <div class="d-flex align-items-start mb-2">
                            <img class="avatar" src=../IMG/${comment.Avatar} alt="User Avatar" class="rounded me-3" width="50" height="75">
                            <div class="user-info flex-grow-1">
                                <div class="fw-bold text-warning">${comment.Username}</div>
                            </div>
                            <div class="text-end text-white small">
                                <div>${formatDate(comment.CreatedAt)}</div>
                                <div>#${i++}</div>
                            </div>
                        </div>

                        ${quoteHTML}

                        <div class="comment-body mb-3">
                            ${comment.CommentText}
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="#" class="text-danger small">⚠️ Report</a>
                            <div>
                                <a href="#" class="me-3 text-danger"><i class="bi bi-hand-thumbs-up me-1"></i>Like</a>
                                <a href="#" class="text-danger reply-btn"><i class="bi bi-reply me-1"></i>Reply</a>
                            </div>
                        </div>
                    `;
                    // Add event listener to reply button
                    const replyButton = div.querySelector('.reply-btn');
                    replyButton.addEventListener('click', (e) => {
                        e.preventDefault();

                        const replyForm = document.querySelector('form');
                        const replyIDInput = document.getElementById('replyID');
                        const replyPreview = document.getElementById('reply-preview');

                        replyPreview.innerHTML = `
                            <div class="quote border-start ps-3 border-warning position-relative bg-dark p-2 rounded">
                                <div class="quote-author fw-bold text-warning mb-1">${comment.Username} said:</div>
                                <div class="text-light small fst-italic">${comment.CommentText}</div>
                                <button type="button" class="btn btn-sm btn-outline-warning position-absolute top-0 end-0 m-2" id="cancel-reply">
                                    <i class="bi bi-x-lg"></i> Cancel
                                </button>
                            </div>
                        `;
                        // Set the reply ID and scroll
                        replyIDInput.value = comment.CommentID;
                        replyForm.scrollIntoView({ behavior: 'smooth', block: 'center' });

                        // Cancel logic
                        const cancelReplyBtn = document.getElementById('cancel-reply');
                        cancelReplyBtn.addEventListener('click', () => {
                            replyIDInput.value = '0';
                            replyPreview.innerHTML = '';
                        });
                    });


                    commentContainer.appendChild(div);
                });

                // Pagination buttons
                const totalPages = Math.ceil(data.total / commentsPerPage);
                if (totalPages > 1) {
                    // Always show first page
                    const firstBtn = document.createElement('button');
                    firstBtn.innerText = "1";
                    firstBtn.classList.add('page-btn', 'btn', 'btn-sm', 'btn-light', 'mx-1');
                    if (page === 1) firstBtn.classList.add('active');
                    firstBtn.addEventListener('click', () => fetchComments(1));
                    pagination.appendChild(firstBtn);

                    // Show 2 and 3 if they exist
                    for (let i = 2; i <= Math.min(3, totalPages - 1); i++) {
                        const btn = document.createElement('button');
                        btn.innerText = i;
                        btn.classList.add('page-btn', 'btn', 'btn-sm', 'btn-light', 'mx-1');
                        if (i === page) btn.classList.add('active');
                        btn.addEventListener('click', () => fetchComments(i));
                        pagination.appendChild(btn);
                    }

                    // Add ellipsis if totalPages > 4
                    if (totalPages > 4) {
                        const dots = document.createElement('span');
                        dots.innerText = "...";
                        dots.classList.add('mx-2', 'text-muted');
                        pagination.appendChild(dots);
                    }

                    // Add "Last" button
                    if (totalPages > 1) {
                        const lastBtn = document.createElement('button');
                        lastBtn.innerText = totalPages;
                        lastBtn.classList.add('page-btn', 'btn', 'btn-sm', 'btn-light', 'mx-1');
                        if (page === totalPages) lastBtn.classList.add('active');
                        lastBtn.addEventListener('click', () => fetchComments(totalPages));
                        pagination.appendChild(lastBtn);
                    }
                }

                
            });

    }

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    // Load initial comments
    fetchComments(currentPage);
});
