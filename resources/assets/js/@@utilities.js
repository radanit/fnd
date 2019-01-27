import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 3000
  });
window.toast = toast;
export class Alert {
    static success(title = 'عملیات با موفقیت انجام شد', text, confirmButtonText = 'تایید') {
        return swal({
            title,
            text,
            type: 'success',
            confirmButtonText
        });
    }
    
    static warning(title = 'آیا از انجام عملیات اطمینان دارید؟', text = 'این عمل قابل بازگشت نمی باشد', confirmButtonText = 'تایید' , cancelButtonText='انصراف') {
        return new Promise((resolve, reject) => {
            swal({
                title,
                text,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText,
                confirmButtonText
            }).then(result => {
                if(result.value) {
                    resolve('done');
                }
            })
        })
    }

    static error(title = 'Oops...', text = 'انجام عملیات با شکست روبه رو شد', confirmButtonText = 'تایید') {
        return swal({
            title,
            text,
            type: 'error',
            confirmButtonText
        });
    }
    static successToast(title = '') {
        return toast({
            type: 'success',
            title
            });
    }
    static warningToast(title = '') {
        return toast({
            type: 'warning',
            title
            });
    }
    static errorToast(title = '') {
        return toast({
            type: 'error',
            title
            });
    }
}

