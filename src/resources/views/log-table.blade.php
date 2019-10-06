@extends('ModelEventLogger::app')
@section('content')
    @include('ModelEventLogger::response')
    <table class="table table-hover table-sm table-responsive table-bordered ">
        <thead class="thead-dark">
        <tr>
            <th><input type="checkbox" onClick="toggle(this)" /></th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.id') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.model') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.model_id') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.action') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.causer') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.new') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.old') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.created_at') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.revert') !!}</th>
            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.reverted_by') !!}</th>

            <th>{!! trans('ModelEventLogger::model-event-logger.dashboard.labels.reverted_at') !!}</th>

        </tr>
        </thead>
        <tbody>
        @foreach($modelLogs as $log)
            <tr class="@if($log->action == 'delete') danger @elseif($log->action == 'update') warning @elseif($log->action == 'insert') success @endif">
                <td><input type="checkbox" value="{{$log->id}}" name="log_id"></td>
                <td><a href="{{url('model-events/'.$log->id)}}">{{$log->id}}</a></td>
                <td>{{$log->subject_type}}</td>
                <td>{{$log->subject_id}}</td>
                <td>{!! trans('ModelEventLogger::model-event-logger.dashboard.action.'.$log->action) !!}</td>
                <td>{{$log->causer->email ?? ''}}</td>
                <td><?php
                    $old = json_decode($log->old);
                    foreach($old as $key => $value) {
                    	if(strpos('password', $key) !== FALSE) continue;
                    	echo $key.'=> '.$value."<br>";
                    }
                    ?></td>
                <td><?php
	                $new = json_decode($log->new);
	                foreach($new as $key => $value) {
		                if(strpos('password', $key) !== FALSE) continue;
		                echo $key.'=> '.$value."<br>";
	                }
	                ?></td>
                <td>{{$log->created_at}}</td>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"
                            data-whatever="{{$log->id}}">Revert
                    </button>
                </td>
                <td>{{$log->reverter->name ?? ''}}</td>
                <td>{{$log->reverted_at}}</td>
            </tr>
        @endforeach

        </tbody>

    </table>

    <ul class="pagination">
        {{$modelLogs->render()}}
    </ul>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-group" style="display: none;">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="log-id">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Note:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="revertSubmit" onclick="submitRevert()" class="btn btn-primary">Revert</button>

                </div>
                <div id="revertSuccess" style="display:none" class="alert alert-success success"></div>
                <div id="revertLoading" style="display:none" class="alert alert-info loading">Loading...</div>
                <div id="revertError" style="display:none" class="alert alert-danger error"></div>
            </div>
        </div>
    </div>


    @section('scripts')
    <script>
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var logId = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-title').text('Revert Model Event #' + logId)
            modal.find('.modal-body input').val(logId)

            $('#revertLoading').hide();
            $('#revertSuccess').hide();
            $('#revertError').hide();
        })

        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        function submitRevert() {

                let logId = $('#log-id').val();
                let revert_note = $('#message-text').val();
                let formData = new FormData();
                formData.append('revert_note', logId);
                formData.append('message-text', revert_note);

                $('#revertLoading').show();
                $('#revertSuccess').hide();
                $('#revertError').hide();
                $('#revertSubmit').attr('disabled', 'disabled');
                $.ajax({
                    url: "{{url('model-event-revert')}}/"+logId,
                    type: "PATCH",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $('#revertSubmit').removeAttr('disabled');
                        $('#revertLoading').hide();

                        $('#revertError').hide();
                        $('#revertSuccess').show().html(data);

                    },
                    error: function (data) {
                        $('#revertSubmit').removeAttr('disabled');
                        $('#revertLoading').hide();

                        $('#revertSuccess').hide();
                        $('#revertError').show().html(data.responseText);

                    }
                });
            }

        function toggle(source) {
            let checkboxes = document.getElementsByName('log_id');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }

    </script>
        @endsection
@endsection