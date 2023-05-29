@if ($create)
        <div class="modal fade show" id="modal-default" style="display: block; padding-right: 17px;">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">Tambah Penerbit</h4>
                <span wire:click="format" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </span>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input wire:model="nama" type="text" name='namaPenerbit' class="form-control" id="nama" min="1">
                        @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                <span wire:click="format" type="button" class="btn btn-default" data-dismiss="modal">Batal</span>
                <span type="button" onclick="add()" class="btn btn-success">Simpan</span>
                </div>
            </div>
            </div>
        </div>
    @endif

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script>
    function add(){
        let data = new FormData()
        var nama = $("input[name='namaPenerbit']").val()
        if(String(nama).trim() !== ''){
            data.append('nama', String(nama))
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/api/penerbit",
                data: data,
                processData: false,
                contentType: false,
                dataType: "JSON",
                beforeSend:function(){
                    console.log('ini diisi loading')
                },
                success:function(r){
                    console.log('ini loading hilang')
                    console.log(r)
                    location.reload()
                },
                error:function(err){
                    console.log(err)
                }
            })     
        }else{
            alert('Penerbit belum diisi')
        }
           
    }

</script>