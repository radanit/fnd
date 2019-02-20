<template>
<!-- DIRECT CHAT -->
<div class="card direct-chat direct-chat-primary mt-4">
<div class="card-header ui-sortable-handle" style="cursor: move;">
    <h3 class="card-title">Direct Chat</h3>

    <div class="card-tools">
    <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span>
    <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
    </button>
    <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle">
        <i class="fa fa-comments"></i>
    </button>
    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
    </button>
    </div>
</div>
<!-- /.card-header -->
<div class="card-body">
    <!-- Conversations are loaded here -->
    <div class="direct-chat-messages">
    <!-- Message. Default to the left -->
    <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
        <span class="direct-chat-name float-left">Alexander Pierce</span>
        <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="images/user1-128x128.jpg" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
        Is this template really for free? That's unbelievable!
        </div>
        <!-- /.direct-chat-text -->
    </div>
    <!-- /.direct-chat-msg -->

    <!-- Message to the right -->
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
        <span class="direct-chat-name float-right">Sarah Bullock</span>
        <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="images/user3-128x128.jpg" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
        You better believe it!
        </div>
        <!-- /.direct-chat-text -->
    </div>
    <!-- /.direct-chat-msg -->

    <!-- Message. Default to the left -->
    <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
        <span class="direct-chat-name float-left">Alexander Pierce</span>
        <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="images/user1-128x128.jpg" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
        Working with AdminLTE on a great new app! Wanna join?
        </div>
        <!-- /.direct-chat-text -->
    </div>
    <!-- /.direct-chat-msg -->

    <!-- Message to the right -->
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
        <span class="direct-chat-name float-right">Sarah Bullock</span>
        <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
        </div>
        <!-- /.direct-chat-info -->
        <img class="direct-chat-img" src="images/user3-128x128.jpg" alt="message user image">
        <!-- /.direct-chat-img -->
        <div class="direct-chat-text">
        I would love to.
        </div>
        <!-- /.direct-chat-text -->
    </div>
    <!-- /.direct-chat-msg -->

    </div>
    <!--/.direct-chat-messages-->
</div>
<!-- /.card-body -->
<div class="card-footer">
    <form action="#" method="post">
    <div class="input-group">
        <input name="message" placeholder="Type Message ..." class="form-control" type="text">
        <span class="input-group-append">
        <button type="button" class="btn btn-primary">Send</button>
        </span>
    </div>
    </form>
</div>
<!-- /.card-footer-->
</div>
<!--/.direct-chat -->
</template>
<script>
export default {
    created() {
        console.log('Component mounted.')
    }
}
</script>
<style>

</style>
