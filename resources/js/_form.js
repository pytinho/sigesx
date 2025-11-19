import $ from 'jquery';

const REQUIRED_SELECTOR = 'input[required], select[required], textarea[required]';
const EMPTY_CLASS = 'is-empty';
const FEEDBACK_CLASS = 'field-feedback';
const CLIENT_INVALID_CLASS = 'is-invalid';
const CLIENT_INVALID_FLAG = 'clientInvalid';

// Adds a visual asterisk to labels of required fields
function markRequiredFields() {
  $('.form-group').each((_, group) => {
    const $group = $(group);
    const hasRequired = $group.find(REQUIRED_SELECTOR).length > 0;
    const $label = $group.children('label').first();
    if (hasRequired && $label.length && !$label.find('.req-mark').length) {
      $('<span/>', { class: 'req-mark', text: '*' }).appendTo($label);
    }
  });
}

function isFieldEmpty($field) {
  if (!$field.length || $field.prop('disabled')) {
    return false;
  }

  if ($field.is(':checkbox, :radio')) {
    const group = $(`[name="${$field.attr('name')}"]`);
    return group.filter(':checked').length === 0;
  }

  const value = $field.val();
  if (Array.isArray(value)) {
    return value.length === 0;
  }

  return String(value ?? '').trim() === '';
}

function ensureFeedback($group, message) {
  let $feedback = $group.find(`.${FEEDBACK_CLASS}`);
  if (!$feedback.length) {
    $feedback = $('<div/>', {
      class: `invalid-feedback ${FEEDBACK_CLASS}`,
      text: message,
    }).appendTo($group);
  }
  $feedback.show();
  return $feedback;
}

function clearFeedback($group) {
  $group.find(`.${FEEDBACK_CLASS}`).remove();
}

function markClientInvalid($field) {
  if ($field.data(CLIENT_INVALID_FLAG)) {
    return;
  }
  $field.addClass(CLIENT_INVALID_CLASS).data(CLIENT_INVALID_FLAG, true);
  $field.attr('aria-invalid', 'true');
}

function clearClientInvalid($field) {
  if (!$field.data(CLIENT_INVALID_FLAG)) {
    return;
  }
  $field.removeClass(CLIENT_INVALID_CLASS).removeData(CLIENT_INVALID_FLAG);
  $field.removeAttr('aria-invalid');
}

function validateField($field) {
  const $group = $field.closest('.form-group');
  const hasServerFeedback = $group.find('.invalid-feedback').not(`.${FEEDBACK_CLASS}`).length > 0;
  const message = $field.data('empty-message') || 'Campo obrigatório';
  const empty = isFieldEmpty($field);

  if (empty) {
    $field.addClass(EMPTY_CLASS);
    if (!hasServerFeedback) {
      markClientInvalid($field);
      ensureFeedback($group, message);
    }
    return true;
  }

  $field.removeClass(EMPTY_CLASS);
  if (!hasServerFeedback) {
    clearClientInvalid($field);
    clearFeedback($group);
  }
  return false;
}

function validateForm($form) {
  let firstInvalid = null;
  $form.find(REQUIRED_SELECTOR).each((_, element) => {
    const $field = $(element);
    const empty = validateField($field);
    if (empty && !firstInvalid) {
      firstInvalid = $field;
    }
  });

  return firstInvalid;
}

$(function () {
  // Mark labels of required inputs with an asterisk
  markRequiredFields();

  $('form[data-watch-empty]').each((_, form) => {
    const $form = $(form);
    const $requiredFields = $form.find(REQUIRED_SELECTOR);

    $requiredFields.on('blur input change', function () {
      validateField($(this));
    });

    $form.on('submit', function (event) {
      const firstInvalid = validateForm($form);
      if (firstInvalid) {
        event.preventDefault();
        firstInvalid.trigger('focus');
        if (typeof firstInvalid[0].scrollIntoView === 'function') {
          firstInvalid[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
      }
    });
  });
});
