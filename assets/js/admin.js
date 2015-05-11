jQuery(document).ready(function($){

  $('select[id*="-use_res"]').each(function(e, i){
    ytc_toggle_widget_option_select($(this).attr('id'), 2);
  });
  $('select[id*="-use_res"]').on('change', function(e, i){
    ytc_toggle_widget_option_select($(this).attr('id'), 2);
  });
  $('input[id*="-showgoto"]').each(function(e, i){
    ytc_toggle_widget_option_checkbox($(this).attr('id'));
  });
  $('input[id*="-showgoto"]').on('change', function(e, i){
    ytc_toggle_widget_option_checkbox($(this).attr('id'));
  });

  $(document).ajaxSuccess(function(e, xhr, settings){
    $('select[id*="-use_res"]').each(function(e, i){
      ytc_toggle_widget_option_select($(this).attr('id'), 2);
    });
    $('select[id*="-use_res"]').on('change', function(e, i){
      ytc_toggle_widget_option_select($(this).attr('id'), 2);
    });
    $('input[id*="-showgoto"]').each(function(e, i){
      ytc_toggle_widget_option_checkbox($(this).attr('id'));
    });
    $('input[id*="-showgoto"]').on('change', function(e, i){
      ytc_toggle_widget_option_checkbox($(this).attr('id'));
    });
  });

  function ytc_toggle_widget_option_select(id, value) {
    if ( $('#' + id).val() == value ) {
      $('p.' + id).addClass('visible').removeClass('hidden');
    } else {
      $('p.' + id).addClass('hidden').removeClass('visible');
    }
  }
  function ytc_toggle_widget_option_checkbox(id) {
    if ( $('#' + id).attr('checked') === 'checked' ) {
      $('p.' + id).addClass('visible').removeClass('hidden');
    } else {
      $('p.' + id).addClass('hidden').removeClass('visible');
    }
  }

});