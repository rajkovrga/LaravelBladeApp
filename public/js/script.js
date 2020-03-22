document.addEventListener("DOMContentLoaded",function() {
    let moreCommentsBtn = document.getElementById('more-comments')
    let comments = document.getElementById('comment-items')
    if (moreCommentsBtn) {
        moreCommentsBtn.addEventListener('click',  () =>  {
            let id = moreCommentsBtn.getAttribute('data-id');
            let page = moreCommentsBtn.getAttribute('data-page');
            let next = parseInt(page) + 1;
            axios.get('/comments/' + id + "/page/" + next)
                .then((result) => {
                    moreCommentsBtn.setAttribute('data-page', result.data.current_page);
                    if (result.data.current_page == result.data.last_page) {
                        moreCommentsBtn.style.display = "none"
                    }
                    let newData = "";
                    result.data.data.forEach((row) => {
                        newData += `<div class="row">
                        <div class="col-3 d-flex text-center justify-content-center align-items-center flex-column">
                            <img src="`;

                            if(row.image_url == null){
                                newData += "/images/avatar.jpg";
                            }
                            else {
                                newData += `/images/avatars/${row.image_url}`;
                            }

                        newData += `" alt="avatar" class="image-avatar">
                            <span>${row.username}</span>
                            <span class="d-flex justify-content-center flex-column align-items-center">
                                <i class="heart-item fa fa-heart `;
                        if (row.user_liked != 0) {
                                newData += 'heart-red';
                        } else {
                            newData += 'heart-classic';
                        }
                        newData += ` " id="heart-item" data-id="${row.id}" aria-hidden="true"></i>
                                <p class="count-comment-likes" id="count-comment-likes">${row.numberLikes}</p>
                            </span>
                        </div>
                        <div class="col-9 ">
                            <p>${row.desc}</p>
                        </div>
                    </div>`;
                    });
                    comments.innerHTML += newData

                    checkLikeComment()
                })
                .catch((error) => {
                    console.log(error)
                })
        });
    }


    let likeButton = document.getElementById('like-button');
    let likes = document.getElementById('count-likes');
    likeButton.addEventListener('click',  () => {
        let id = likeButton.getAttribute('data-id');
        if (likeButton.classList.contains('liked-button')) {
            axios.post('/post/unlike', {id})
                .then((result) => {
                    likes.innerHTML = result.data.number;
                    likeButton.classList.remove('liked-button');
                    likeButton.classList.add('like-button');
                })
                .catch((err) => console.log(err))
        } else {
            axios.post('/post/like', {id})
                .then((result) => {
                    likes.innerHTML = result.data.number;
                    likeButton.classList.remove('like-button');
                    likeButton.classList.add('liked-button');
                })
                .catch((err) =>  window.location.href = '/login')
        }
    })

    checkLikeComment()
    function checkLikeComment() {
        let commentLikeButton = document.getElementsByClassName('heart-item');
        let commentLikes = document.getElementsByClassName('count-comment-likes');

        for (let i = 0; i < commentLikeButton.length; i++)
        {
            commentLikeButton[i].addEventListener('click', function() {
                let id = this.getAttribute('data-id');
                let postId = this.getAttribute('data-post');
                if(commentLikeButton[i].classList.contains('heart-red'))
                {
                    axios.post('/comment/unlike',{id,postId})
                        .then((result) => {
                            commentLikes[i].innerHTML = result.data.number[0].number;
                            commentLikeButton[i].classList.remove('heart-red');
                            commentLikeButton[i].classList.add('heart-classic');
                        })
                        .catch((err) => console.log(err))
                }
                else
                {
                    axios.post('/comment/like',{id})
                        .then((result) => {
                            commentLikes[i].innerHTML = result.data.number[0].number;
                            commentLikeButton[i].classList.remove('heart-classic');
                            commentLikeButton[i].classList.add('heart-red');
                        })
                        .catch((err) => console.log(err))
                }
            })
        }
    }



});
