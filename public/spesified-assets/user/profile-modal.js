const modalEditProfile = document.getElementById('editProfileModal');
const modalEditProfileInstance = bootstrap.Modal.getOrCreateInstance(modalEditProfile);
modalEditProfile.addEventListener('show.bs.modal', async () => {
    drawHistoriDiagnosisTable();

    const btnSubmitEditProfile = document.getElementById('btnSubmitEditProfile');
    btnSubmitEditProfile.addEventListener('click', async (e) => {
        e.preventDefault();
        Swal.fire({
            title: 'Mohon tunggu',
            html: 'Sedang memproses data',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            },
        });
        try {
            const response = await ajaxPostEditProfile();
            await new Promise(resolve => setTimeout(resolve, 1000)); // Delay selama 1 detik
            await Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message,
                showConfirmButton: false,
                timer: 1500
            });
            return window.location.reload();
        } catch (error) {
            swalError(error.responseJSON);
        }
    });

    const setElementAttributes = (element, value, disabled = false) => {
        element.value = value;
        element.disabled = disabled;
    };

    const elements = {
        nameInput: document.querySelector('input[name="name"]'),
        emailInput: document.querySelector('input[name="email"]'),
        addressTextarea: document.querySelector('textarea[name="address"]'),
        genderSelect: document.querySelector('#gender'),
        kelasInput: document.querySelector('#kelas'),
        
    };

    setElementAttributes(elements.nameInput, 'Mohon Tunggu...', true);
    setElementAttributes(elements.emailInput, 'Mohon Tunggu...', true);
    setElementAttributes(elements.addressTextarea, 'Mohon Tunggu...', true);
    let optiongender = new Option('Mohon Tunggu', null, false, false);
    
    let optionkelas = new Option('Mohon Tunggu', null, false, false);
    $(elements.genderSelect).append(optiongender).attr('disabled', true);
    
    $(elements.kelasInput).append(optionkelas).attr('disabled', true);

    $(elements.genderSelect).select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#editProfileModal'),
    });

    $(elements.kelasInput).select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#editProfileModal'),
    });

    try {
        const response = await ajaxRequestEditProfile();
        $(elements.kotaSelect).empty();

        if (response.user.profile == null) {
            response.user.profile = {
                address: '',
                gender: '',
                kelas: '',
            }
            
        } else {
            
        }

        setElementAttributes(elements.nameInput, response.user.name);
        setElementAttributes(elements.emailInput, response.user.email);
        setElementAttributes(elements.addressTextarea, response.user.profile.address);

        $(elements.genderSelect).empty();
        optiongender = new Option('Pilih gender', null, false, true);
        $(elements.genderSelect).append(optiongender).attr('disabled', false);
        optiongender.disabled = true;

        $(elements.kelasInput).empty();
        optionkelas = new Option('Pilih Kelas', null, false, true);
        $(elements.kelasInput).append(optionkelas).attr('disabled', false);
        optionkelas.disabled = true;


        response.gender.forEach(value => {
            if (value == response.user.profile.gender) {
                const option = new Option(value, value, true, true);
                $(elements.genderSelect).append(option);
            } else {
                const option = new Option(value, value, false, false);
                $(elements.genderSelect).append(option);
            }
        });
        response.kelas.forEach(value => {
            if (value == response.user.profile.kelas) {
                const option = new Option(value, value, true, true);
                $(elements.kelasInput).append(option);
            } else {
                const option = new Option(value, value, false, false);
                $(elements.kelasInput).append(option);
            }
        });
    } catch (error) {
        swalError(error.responseJSON);
    }


    // $(elements.genderSelect).on('select2:select', async (e) => {
    //     $(elements.kotaSelect).empty();
    //     optionKota = new Option('Mohon Tunggu', null, false, false);
    //     $(elements.kotaSelect).append(optionKota).attr('disabled', true);
    //     try {
    //         const response = await ajaxCityRequest(e.params.data.id);
    //         $(elements.kotaSelect).empty();
    //         optionKota = new Option('Pilih Kota', null, false, true);
    //         optionKota.disabled = true;
    //         $(elements.kotaSelect).append(optionKota).attr('disabled', false);
    //         response.forEach(value => {
    //             const option = new Option(value.city_name, value.city_id,
    //                 false,
    //                 false);
    //             $(elements.kotaSelect).append(option);
    //         });
    //     } catch (error) {
    //         if (!error.status == 404) {
    //             swalError(error.responseJSON);
    //         }
    //     }
    // });
});

$(document).on('select2:open', () => {
    window.addEventListener('keydown', function (e) {
        let dropdown = $('.select2-hidden-accessible');
        if ((e.key === 'Escape' || e.key === 'Esc') && $('.select2-container--open').length) {
            e.stopPropagation();
            dropdown.select2('close');
            return false;
        }
    }, true);
});

modalEditProfile.addEventListener('hide.bs.modal', async () => {
    $('#gender').empty();
    $('#kota').empty();
    $('#kelas').empty();
});

