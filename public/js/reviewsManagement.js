
const deleteModal = document.getElementById('deleteReviewModal');
      
if (deleteModal) {
    deleteModal.addEventListener('show.bs.modal', event => {

    const button = event.relatedTarget;
          
    const reviewId = button.getAttribute('data-bs-id');
    const userName = button.getAttribute('data-bs-user');
          

    const modalReviewIdInput = deleteModal.querySelector('#modalReviewId');
    const modalUserNameSpan = deleteModal.querySelector('#modalUserName');
    // const modalForm = deleteModal.querySelector('#deleteReviewForm');
          
    modalReviewIdInput.value = reviewId;
    modalUserNameSpan.textContent = userName;
          
    // modalForm.action = 'delete_review.php?id=' + reviewId;
    });
}