<!-- Modal -->
<script>
function emptyPlaylist() {
  $.redirect('', {'empty': 'true'})
}
</script>
<div class="modal fade" id="emptyPlayListModal" tabindex="-1" role="dialog" aria-labelledby="emptyPlayListModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php txt('warning'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php txt('confirm_empty_playlist'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php txt('cancel'); ?></button>
        <button type="button" class="btn btn-warning" onClick="emptyPlaylist()"><?php txt('confirm'); ?></button>
      </div>
    </div>
  </div>
</div>