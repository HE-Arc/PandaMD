<script>

    function OnreadyChangeFileFolder() {

        let url = "{{route('changeFileFolderId',':id')}}";
        let selectData = {};
        $("select[id^='selectedFile']").each(function () {
            selectData[$(this).attr('name')] = $(this).val();
        });
        $("select[id^='selectedFile']").on('change', function () {
            let fileId = $(this).attr('title');
            url = url.replace(":id", fileId);
            //change clicked folder to bold and selected icon
            let newFolderId = $(this).val();
            console.log(url);
            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newFolderId: newFolderId})
            }).then(response => {
                if (!response.ok) {
                    $(this).val(selectData[fileId]).select();
                    throw new Error(response.statusText)
                }
                return response.json();

            }).then(function (data) {
                if(!data.state){
                    $(this).val(selectData[fileId]).select();
                    throw new Error(response.statusText)
                }
                else{
                    location.reload();
                }
            })
                .catch(error => {
                    console.log(error);
                    swal({
                        type: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again',
                    })
                })
        });


    }
</script>
