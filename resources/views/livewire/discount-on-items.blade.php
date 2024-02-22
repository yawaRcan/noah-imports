<div>
    <td class="text-right">
        <div class="form-check">
            <input class="form-check-input" name="discount" type="checkbox" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Apply Discount
            </label><br>
            -{{$discount}}%
        </div>
    </td>


    {{-- <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> --}}
  
  <!-- Modal -->
  <div class="modal fade" wire:ignore.self id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form wire:submit="save">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Discount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label>{{$discount}}</label>
         <input type="text" class="form-control" wire:model="discount">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" wire:click="save()"class="btn btn-primary">submit</button>
        </div>
    </form>
      </div>
    </div>
  </div>
</div>
