<script>

     function onReadyRename(btnName,url,type) {
        $(`button[id^=${btnName}]`).click(function (event) {
            let id = $(this).val();
            url = url.replace(":id",id);
            let innerText = $(`.${type}${id}`).text();
            url=url.replace(":id",id);
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
                preConfirm: (fileName) => {
                    return fetch(url, {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({newName: fileName})
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
                    $(`.${type}${id}`).text(result.value.newName);
                });

            })

        })
    }
</script>