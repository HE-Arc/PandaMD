<script>
    function OnreadyChangeRight() {
        let url = "{{route('changeRight',':id')}}";
        $("select[id^='select']").on('change', function () {
            let id = $(this).attr('name');
            url = url.replace(":id", id);
            let right = $(this).val();
            fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({newRight: right})
            }).then(response => {
                console.log(JSON.stringify({newRight: right}));
                if (!response.ok) {
                    $(`select[name=${id}]`)
                    throw new Error(response.statusText)

                }

            })
                .catch(error => {
                    console.log(error);
                })

        });

    }
</script>
