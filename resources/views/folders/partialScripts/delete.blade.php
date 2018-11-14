<script>
    var onReadyDelete = function () {
        $("button[id^='btnRenameDelete']").click(function (event) {
            let value = $(this).val();
            let id = $(this).attr("name");
            let that = $(event.currentTarget);
            event.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: `Yes, delete ${value}`,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch('{{url('/folders')}}' + '/' + id, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },

                        body: JSON.stringify({newName: folderName})
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
                        `${value} Deleted`,
                        'success'
                    ).then( () =>{
                        that.parents('a').remove();
                    })
                }else{
                    swal({
                        type: 'error',
                        title: 'Cancelled',
                        text: `${value} not cancelled`,
                    })
                }
            })

        })
    }
</script>

