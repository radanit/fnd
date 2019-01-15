<template>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">{{trans('userGroup.cardTitle')}}</div>
                    <div class="card-body">
                       {{trans('userGroup.cardBody')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
