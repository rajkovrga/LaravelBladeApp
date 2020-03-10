document.addEventListener("DOMContentLoaded",function()
{
    let moreCommentsBtn = document.getElementById('more-comments')
    let comments = document.getElementById('comment-items')
    if(moreCommentsBtn)
    {
        moreCommentsBtn.addEventListener('click',function () {
            let id = this.getAttribute('data-id');
            let page = this.getAttribute('data-page');
            let next = parseInt(page ) + 1;
            axios.get('/comments/' + id + "/page/" + next)
                .then(function (result) {
                    moreCommentsBtn.setAttribute('data-page',result.data.current_page);
                    if(result.data.current_page == result.data.last_page)
                    {
                        moreCommentsBtn.style.display = "none"
                    }
                    let newData = "";
                    result.data.data.forEach((row) => {
                        newData += `<div class="row">
                        <div class="col-3 d-flex text-center justify-content-center align-items-center flex-column">
                            <img src="${window.location.origin}/images/avatar.jpg" alt="avatar" class="image-avatar">
                            <span>${row.username}</span>
                        </div>
                        <div class="col-9 ">
                            <p>${row.desc}</p>
                        </div>
                    </div>`;
                    });
                    comments.innerHTML += newData
                })
                .catch(function (error) {
                    console.log(error)
                })
        });
    }


    let likeButton = document.getElementById('like-button');
    let likes = document.getElementById('count-likes');
    likeButton.addEventListener('click',function () {
        let id = likeButton.getAttribute('data-id');
        console.log(11111)
        if(likeButton.classList.contains('liked-button'))
        {
            axios.post('/post/unlike',{id})
                .then(function (result) {
                    likes.innerHTML = result.data.number;
                    likeButton.classList.remove('liked-button');
                    likeButton.classList.add('like-button');
                })
                .catch(function (err) {
                    console.log(err);
                })
        }
        else
        {
            axios.post('/post/like',{id})
                .then(function (result) {
                    likes.innerHTML = result.data.number;
                    likeButton.classList.remove('like-button');
                    likeButton.classList.add('liked-button');
                })
                .catch(function (err) {
                    console.log(err);
                    window.location.href = '/login';

                })
        }
    })

});
