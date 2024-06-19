const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});

document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');

    // Cargar el estado de los likes desde localStorage
    likeButtons.forEach(button => {
        const postId = button.getAttribute('data-post-id');
        const liked = localStorage.getItem(`liked_${postId}`) === 'true';
        const likeCountElement = button.querySelector('.like-count');
        const initialLikes = parseInt(likeCountElement.textContent);

        if (liked) {
            button.classList.add('liked');
            button.innerHTML = `<i class="lni lni-heart-filled"></i> <span class="like-count" data-post-id="${postId}">${initialLikes + 1}</span> Te Gusta`;
        }
    });

    // Manejar el evento de clic en los botones de like
    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const liked = this.classList.contains('liked');
            const likeCountElement = this.querySelector('.like-count');
            let likeCount = parseInt(likeCountElement.textContent);

            if (liked) {
                // Quitar "Me Gusta"
                this.classList.remove('liked');
                this.innerHTML = `<i class="lni lni-heart"></i> <span class="like-count" data-post-id="${postId}">${likeCount - 1}</span> Me Gusta`;
                localStorage.setItem(`liked_${postId}`, 'false');
            } else {
                // Dar "Me Gusta"
                this.classList.add('liked');
                this.innerHTML = `<i class="lni lni-heart-filled"></i> <span class="like-count" data-post-id="${postId}">${likeCount + 1}</span> Te Gusta`;
                localStorage.setItem(`liked_${postId}`, 'true');
            }
        });
    });
});
