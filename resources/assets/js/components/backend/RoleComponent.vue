<template>
    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" aria-labelledby="modalCreatelLabel" role="dialog" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-simple">
            <form class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="modalCreatelLabel">Set The Messages</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-4 form-group">
                            <input class="form-control" name="firstName" placeholder="First Name" type="text">
                        </div>
                        <div class="col-xl-4 form-group">
                            <input class="form-control" name="lastName" placeholder="Last Name" type="email">
                        </div>
                        <div class="col-xl-4 form-group">
                            <input class="form-control" name="email" placeholder="Your Email" type="email">
                        </div>
                        <div class="col-xl-12 form-group">
                            <textarea class="form-control" rows="5" placeholder="Type your message" spellcheck="true" style="z-index: auto; position: relative; line-height: 22px; font-size: 14px; transition: none 0s ease 0s; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"></textarea>
                        </div>
                        <div class="col-md-12 float-right">
                            <button class="btn btn-primary waves-effect waves-classic" data-dismiss="modal" type="button">Add Comment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Modal Create-->
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>