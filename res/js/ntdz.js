const {__, _x, _n, sprintf} = wp.i18n;

jQuery(document).ready(function ($) {
    var urlHrefCropper = window.location.href,
        baseHrefCropper = urlHrefCropper.split('/wp-admin/');
    $('.toCropper').attr('href', baseHrefCropper[0] + '/wp-admin/upload.php');

    function getUserTimezone() {
        let defaultTimeZone = 'Europe/Paris';
        try {
            return Intl.DateTimeFormat().resolvedOptions().timeZone;
        } catch (e) {
            return defaultTimeZone;
        }
    }

    const $timeZoneInput = $('#time_zone');
    if ($timeZoneInput.length) {
        const userTimezone = getUserTimezone();
        $timeZoneInput.val(userTimezone);
    }

    // Get the browser's language preference
    var userLanguage = navigator.language || navigator.userLanguage;
    var locale = userLanguage.split('-')[0];

    var url = window.location.href;
    var arr = url.split("/");
    var label = arr[2];

    const clientType = $('#nadz_profile_type').val();
    const CLIENT_TYPE_ADVERTISER = 'ADVERTISER';

    // Used to hide and display elements depending on clicked tab
    function changeTab(tabId) {
        $('.ntdz_active_tab').removeClass('ntdz_active_tab');
        $('.ntdz-template-page').addClass('ntdz-none');
        $('#'+ tabId).addClass('ntdz_active_tab');
        const page = tabId.replace('tab', 'page');
        $('#'+ page).removeClass('ntdz-none');
        if (tabId === 'ntdz_dashboard_tab') {
            // todo: what is script_success, there is no such div ?
            $('#script_success').addClass('ntdz-none');
        }
    }

    // When connected, if user chooses to apply existing template, retrieve and insert code
    function confirmAddTemplate(id) {
        $.post(ajax_var.url, {
            'action': 'confirm_template',
            'nonce': ajax_var.nonce,
            'id': id
        }, function (response) {
            if (response.success) {
                if (clientType !== CLIENT_TYPE_ADVERTISER && !$('.ntdz_notif_warning').hasClass('ntdz-none')) {
                    if (locale === 'fr') {
                        alert(__('Votre script a été implémenté avec succès. Vous pouvez configurer le template de collecte.\
                            \nPensez à incorporer nos lignes dans votre ads.txt afin d\'optimiser votre monétisation !'));
                    } else {
                        alert(__('Your script has been successfully implemented. You can configure the collection template.\
                        \nRemember to incorporate our lines into your ads.txt to optimize your monetization!'));
                    }
                } else {
                    if (locale === 'fr') {
                        alert(__('Votre script a été implémenté avec succès. Vous pouvez configurer le template de collecte.', 'notifadz-by-adrenalead-web-push-notifications'));
                    } else {
                        alert(__('Your script has been successfully implemented. You can configure the collection template.', 'notifadz-by-adrenalead-web-push-notifications'));
                    }
                }
                location.reload();
            } else {
                showErrors(response.body);
                location.reload();
            }
        }, 'json');
    }

    // Action FORM
    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    // Set notification (ads.txt)
    function setNotif() {
        $('.ntdz_notif').removeClass('ntdz-none');
    }

    // Remove notification (ads.txt)
    function removeNotif() {
        $('.ntdz_notif').addClass('ntdz-none');
    }

    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function (m) {
            return map[m];
        });
    }

    function nl2br(text) {
        return text.replace(/(?:\r\n|\r|\n)/g, '<br>');
    }

    function checkAds() {
        $.post(ajax_var.url, {
            'action': 'check_ads',
            'nonce': ajax_var.nonce,
            'params': {label: label}
        }, function (response) {
            if (response.success === true) {
                removeNotif();
            } else {
                setNotif();
            }
        }, 'json');
    }

    // Bind copy to clipboard
    $('.btn-copy-textarea').on('click', function (e) {
        e.preventDefault();
        const textareaToCopy = $(this).data('textarea-id');
        const copyText = $('#' + textareaToCopy).text();
        const textArea = document.createElement('textArea');
        textArea.textContent = copyText;
        document.body.append(textArea);
        textArea.select();
        document.execCommand('copy');
        textArea.remove();
        if (locale === 'fr') {
            alert(__('Les lignes ont bien été copiées', 'notifadz-by-adrenalead-web-push-notifications'));
        } else {
            alert(__('The lines have been successfully copied.', 'notifadz-by-adrenalead-web-push-notifications'));
        }
    })

    // Bind input change / focusout on url input => update img src attribute
    $('.url-input').on('change, focusout', function (e) {
        let idImgInput = $(this).data('img'),
            src = $(this).val();
        if (src && src.length > 0) $('#' + idImgInput).attr('src', src);
    })

    // Bind click on each tab, and call changeTab function with right parameters
    $('.ntdz_tab').on('click', function (e) {
        if (e.target !== this) {
            e.target = $(e.target).parent()[0];
        }
        changeTab(e.target.id)
    })

    // Bind click template type choice => add active class
    $('.typeChoice').on('click', function (e) {
        $('.ntdz_tempActive').removeClass('ntdz_tempActive');
        $(this).addClass('ntdz_tempActive');
    })

    // Bind submit action of connection via email / password.
    $('#ntdz_connect_email').on('submit', function (e) {
        e.preventDefault();
        $('#loginSubmit').prop('disabled', true);
        $.post(ajax_var.url, {
            'action': 'login_email',
            'nonce': ajax_var.nonce,
            'email': $("#loginEmail").val(),
            'password': $("#loginPassword").val(),
            'label': label,
        }, function (response) {
            if (response.success === false) {
                showErrors(response.body);
                $('#loginSubmit').prop('disabled', false);
                return false;
            }
            if (response.body === "403") {
                subscriptionRequired();
                $('#loginSubmit').prop('disabled', false); 
                return false;
            }
            if (response.shouldConfirmTemplate === true) {
                confirmTemplateIfNeeded(response.templateId);
            } else {
                location.reload();
            }
        }, 'json');
        return false;
    });

    // Add or Update template
    $('#ntdz_get_template').submit(function (e) {
        if ($('.ntdz_tempActive').length > 0) {
            e.preventDefault();
            var form = $('#ntdz_get_template');
            let body = getFormData(form),
                type = $('.ntdz_tempActive').data('type');
            body.label = arr[2];
            body.type = type;
            body.colorsCatchMessage = $('#colorCatchMessage').val() ? $('#colorCatchMessage').val() : $('#colorCatchMessage').data('default-color');
            body.colorsQuoteMessage = $('#colorQuoteMessage').val() ? $('#colorQuoteMessage').val() : $('#colorQuoteMessage').data('default-color');
            body.colorsContentMessage = $('#colorContentMessage').val() ? $('#colorContentMessage').val() : $('#colorContentMessage').data('default-color');
            body.logo = $('#logo').val() ? $('#logo').val() : '';
            body.logoMobile = $('#logoMobile').val() ? $('#logoMobile').val() : '';
            body.textMobile = $('#textMobile').val() ? $('#textMobile').val() : '';

            var templateDatas = $('#nadz_script').val();
            var route = (templateDatas == 0) ? 'add_template' : 'update_template';
            $('#get_script').prop('disabled', true);
            $.post(ajax_var.url, {
                'action': route,
                'nonce': ajax_var.nonce,
                'params': body
            }, function (response) {
                $('#get_script').prop('disabled', false);
                if (false === response.success) {
                    showErrors(response.body);
                    return false;
                }
                if (clientType !== CLIENT_TYPE_ADVERTISER && !$('.ntdz_notif_warning').hasClass('ntdz-none')) {
                    $.post(ajax_var.url, {
                        'action': 'get_ads_txt',
                        'nonce': ajax_var.nonce
                    }, function (response) {
                        var escapedAndFormattedContent = nl2br(escapeHtml(response));
                        $('#nadzAdsLine').html(escapedAndFormattedContent);
                        $('#nadzAdsLine_textarea').text(response);
                        changeTab('ntdz_fonctionnalites_tab');
                    })
                    if (locale === 'fr') {
                        alert(__('Votre script a bien été enregistré. Rendez-vous sur votre page d\'accueil pour visualiser le template de collecte.\
                        \nPensez à incorporer nos lignes dans votre ads.txt afin d\'optimiser votre monétisation !', 'notifadz-by-adrenalead-web-push-notifications'));
                    } else {
                        alert(__('Your script has been successfully saved. Visit your homepage to view the collection template.\
                        \nRemember to incorporate our lines into your ads.txt to optimize your monetization!', 'notifadz-by-adrenalead-web-push-notifications'));
                    }
                } else {
                    if (locale === 'fr') {
                        alert(__('Votre script a bien été enregistré. Rendez-vous sur votre page d\'accueil pour visualiser le template de collecte.', 'notifadz-by-adrenalead-web-push-notifications'));
                    } else {
                        alert(__('Your script has been successfully saved. Visit your homepage to view the collection template.', 'notifadz-by-adrenalead-web-push-notifications'));
                    }
                }

                $("#nadz_script").val(1);
                $("#script_success").removeClass('ntdz-none');
                $('#ntdz_template_config').remove();
                window.scrollTo(0, 0);
            }, 'json');
        } else {
            alert(__('Il vous faut sélectionner un template, perso ou optinBox.', 'notifadz-by-adrenalead-web-push-notifications'));
        }
        return false;
    });

    // Password meter
    $('body').on('keyup', 'input[name=user_password], input[name=user_passwordConfirm]', function () {
        checkPasswordStrength(
            $('input[name=user_password]'),
            $('input[name=user_passwordConfirm]'),
            $('#pass-strength-result'),
            $('#submit_create_account'),
        );
    });

    // Add new user
    $('#ntdz_subsc_account').submit(function (e) {
        e.preventDefault();
        const form = $(this);
        let body = getFormData(form);
        body.protocol = arr[0] + "//";
        body.label = label;
        body.activated = 1;

        if (!$('input#accept_conditions:checked').length) {
            if (locale === 'fr') {
                alert(__("Merci d'accepter les conditions générales pour créer votre compte", 'notifadz-by-adrenalead-web-push-notifications'));
            } else {
                alert(__('You must accept the general conditions to create your account', 'notifadz-by-adrenalead-web-push-notifications'));
            }
            return false;
        }

        $('#submit_create_account').prop('disabled', true);
        $.post(ajax_var.url, {
            'action': 'add_user',
            'nonce': ajax_var.nonce,
            'params': body
        }, function (response) {
            if (response.success === false) {
                showErrors(response.body);
                $('#submit_create_account').prop('disabled', false);
                return false;
            }
            if (response.body === "403") {
                subscriptionRequired();
                $('#submit_create_account').prop('disabled', false); 
                return false;
            }
            location.reload();
        }, 'json')
    });

    // Update triggers tab
    $('#ntdz_triggers').submit(function (e) {
        e.preventDefault();
        const form = $(this);
        let body = getFormData(form);
        $('#ntdz_triggers_submit_btn').prop('disabled', true);
        $.post(ajax_var.url, {
            'action': 'activate_scripts_triggers',
            'nonce': ajax_var.nonce,
            'params': body
        }, function (response) {
            $('#ntdz_triggers_submit_btn').prop('disabled', false);
            if (response.success === false) {
                showErrors(response.body);
                return false;
            }
        }, 'json')
    });

    function showErrors(errors) {
        if (typeof errors === 'string') {
            alert(errors);
        } else {
            let strError = '';
            if (Array.isArray(errors.message)) {
                errors = errors.message;
            }
            $.each(errors, function (index, err) {
                strError += err + '\n';
            })
            alert(strError);
        }
    }

    // Bind events on color picker
    jQuery('.wp-picker-holder').on('click', function (e) {
        if (document.getElementById('colorCatchMessage')) {
            var colorCatchMessage = document.getElementById('colorCatchMessage').value;
            document.getElementById('spanCatchMessage').setAttribute('data-color', colorCatchMessage)
        }
        if (document.getElementById('colorQuoteMessage')) {
            var colorQuoteMessage = document.getElementById('colorQuoteMessage').value;
            document.getElementById('spanQuoteMessage').setAttribute('data-color', colorQuoteMessage)
        }
        if (document.getElementById('colorContentMessage')) {
            var colorContentMessage = document.getElementById('colorContentMessage').value;
            document.getElementById('spanContentMessage').setAttribute('data-color', colorContentMessage)
        }
    });

    // Get CGV for login
    let cgvClientTypeToId = [];
    let $selectStatus = $('#SelectStatus');

    function getCgvCollectionAndFillInput() {
        $.post(ajax_var.url, {
            'action': 'get_cgv',
            'nonce': ajax_var.nonce,
        }, function (response) {
            $selectStatus.prop('disabled', false);
            if (false === response.success) {
                showErrors(response.body);
            } else {
                for (const [name, cgv] of Object.entries(response.body)) {
                    cgvClientTypeToId[cgv.clientType] = {'id': cgv.id, 'url': cgv.url[locale]};
                }
            }
        }, 'json');
    }

    if (false === $('#ntdz_subscription').hasClass('ntdz-none')) {
        $selectStatus.prop('disabled', true);
        getCgvCollectionAndFillInput();
        $selectStatus.on('change', function () {
            $('#cgv_id').val(cgvClientTypeToId[$(this).val()].id);
            $('#fieldset-link-general-conditions').removeClass('ntdz-none');
            $('#link-general-conditions').attr('href', cgvClientTypeToId[$(this).val()].url);
        });
    }

    function confirmTemplateIfNeeded(templateId = 0) {
        let confirmMessage = __('Connexion réussie.\n Il semble qu\'un template est déjà relié à ce site. Voulez-vous l\'activer ?', 'notifadz-by-adrenalead-web-push-notifications');
        if (locale !== 'fr') {
            confirmMessage = __('Connection successful.\n It appears that a template is already linked to this site. Do you want to activate it?', 'notifadz-by-adrenalead-web-push-notifications');
        }
        if (confirm(confirmMessage)) {
            const id = templateId === 0 ? $('#nadz_confirm_template_id').val() : templateId;
            confirmAddTemplate(id);
        }
    }

    function subscriptionRequired() {
        if (locale === 'fr') {
            alert(__('Aucun abonnement actif.\n Merci de contacter nos équipes à l\'adresse trafficking@adrenalead.com.'));
        } else {
            alert(__('No active subscription.\n Please contact our team at trafficking@adrenalead.com.'));
        }
    }

    function checkPasswordStrength($pwd, $confirmPwd, $strengthStatus, $submitBtn) {
        var pwd = $pwd.val();
        var confirmPwd = $confirmPwd.val();
        $submitBtn.attr('disabled', 'disabled');
        $strengthStatus.removeClass('short bad good strong');
        var pwdStrength = 0;
        if (!pwd.match(/[a-z]+/) || !pwd.match(/[A-Z]+/) || !pwd.match(/[0-9]+/) || !pwd.match(/[$@#&!]+/) || pwd.length < 10) {
            pwdStrength = 2;
        } else {
            pwdStrength = wp.passwordStrength.meter(pwd, [], confirmPwd);
        }
        switch (pwdStrength) {
            case 2:
                $strengthStatus.addClass('bad').html(pwsL10n.bad);
                break;
            case 3:
                $strengthStatus.addClass('good').html(pwsL10n.good);
                break;
            case 4:
                $strengthStatus.addClass('strong').html(pwsL10n.strong);
                break;
            case 5:
                $strengthStatus.addClass('short').html(pwsL10n.mismatch);
                break;
            default:
                $strengthStatus.addClass('short').html(pwsL10n.short);
        }
        if ((pwdStrength === 3 || pwdStrength === 4) && '' !== confirmPwd.trim()) {
            $submitBtn.removeAttr('disabled');
        }

        return pwdStrength;
    }

    if (clientType !== CLIENT_TYPE_ADVERTISER) {
        checkAds();
    }
    if (parseInt($('#nadz_need_confirm_template').val()) === 1) {
        confirmTemplateIfNeeded();
    }
    const tabToShow = $('#nadz_tab_to_show').val();
    if (tabToShow !== '') {
        changeTab('ntdz_'+ tabToShow +'_tab');
    }
});