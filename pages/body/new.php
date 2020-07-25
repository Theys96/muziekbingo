<!-- Modal -->
<!--
<script>
function emptyPlaylist() {
  $.redirect('', {'empty': 'true'})
}
</script>
-->
<div class="modal fade" id="createPlayListModal" tabindex="-1" role="dialog" aria-labelledby="createPlayListModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php txt('notice'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="createPlaylistModalText">
        Create playlist?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php txt('cancel'); ?></button>
        <button type="button" class="btn btn-warning" onClick="submit()" id="createPlaylistModalConfirm"><?php txt('confirm'); ?></button>
      </div>
    </div>
  </div>
</div>
