<script>
    function onReadyDelete (btnName,url,type) {
        let cleanUrl = url;
        $(`button[id^=${btnName}]`).click(function (event) {
            let id = $(this).attr("name");
            let url= cleanUrl.replace(":id",id);
            let innerText = $(`.${type}${id}`).text();
            let that = $(event.currentTarget);
            event.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: `Yes, delete ${innerText}`,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(url, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },


                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }

                    })
                        .catch(error => {
                            swal.showValidationMessage(
                                `Request failed: ${error}`
                            )
                        })
                },
                allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
                if(result.value){
                    swal(
                        'Delete',
                        `${innerText} Deleted`,
                        'success'
                    ).then( () =>{
                        location.reload()
                    })
                }
            })

        })
    }
</script>

