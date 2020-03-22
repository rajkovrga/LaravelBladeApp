document.addEventListener('DOMContentLoaded',function () {

    edit('#edit-email','#form-email','#email-content');
    edit('#edit-uname','#form-uname','#uname-content');



    function edit(button, form, content) {
        $(button).click(() => {
            $(form).toggle();
            $(content).toggle();

            let editBtn = $(`${button} i`);
            if($(editBtn).hasClass('fa-pencil'))
            {
                $(editBtn).removeClass('fa-pencil');
                $(editBtn).addClass('fa-close');
                $(button).removeClass('btn-primary');
                $(button).addClass('btn-secondary');
            }
            else
            {
                $(editBtn).removeClass('fa-close');
                $(editBtn).addClass('fa-pencil');
                $(button).removeClass('btn-secondary');
                $(button).addClass('btn-primary');
            }
        });
    }

    let imageEditButton = document.getElementById('image-input');
    let errorImage = document.getElementById("error-image");

    imageEditButton.addEventListener('change',  () => {
        errorImage.innerText = '';
        if(!imageEditButton.files[0].type.match(/.(jpg|jpeg|png|gif)$/i))
        {
            errorImage.innerText = 'Fajl nije u dobrom formatu';
            return;
        }

        let formData = new FormData();
        formData.append('file',imageEditButton.files[0]);

        axios.post('/change/image',formData)
            .then(result => {
                document.getElementById('image-avatar').src = result.data.url;
            })
            .catch((error) => {
                if(error.response.status === 422)
                    errorImage.innerText = 'Fajl nije u dobrom formatu';
                else
                    errorImage.innerText = 'Doslo je do greske';
            });

    });

});
