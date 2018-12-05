<script>

     function onReadyRename(btnName,url,type) {
         let cleanUrl = url;
        $(`button[id^=${btnName}]`).click(function (event) {
            let id = $(this).val();
            let url = cleanUrl.replace(":id",id);
            console.log(url);
            let innerText="";
            if(type=="current"){
                innerText = $(this).attr('name');
            }else{
                innerText = $(`.${type}${id}`).text();
            }

            event.preventDefault();
            swal({
                title: `Rename ${type}: " ${innerText} "`,
                input: 'text',
                inputValue: innerText,
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Rename',
                showLoaderOnConfirm: true,
                preConfirm: (Name) => {
                    return fetch(url, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({newName: Name})
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }

                        return response.json();
                    })
                        .catch(error => {
                            swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
                swal(
                    `${type} Rename`,
                    `${result.value.newName}`,
                    'success'
                ).then(function () {
                    //location.reload();
                    if(type=="current"){
                        $('#currentFolder').text(result.value.newName);
                    }else{
                        $(`.${type}${id}`).text(result.value.newName);
                    }

                });

            })

        })
    }
</script>