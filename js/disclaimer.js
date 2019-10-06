(function($, Drupal, drupalSettings) {
  let nodeId = -1;
  let dialogTitle = '';
  let dialogBody = '';

  drupalSettings.disclaimer.forEach(function (item) {
    nodeId = item.nodeId;
    dialogTitle = item.disclaimerTitle;
    dialogBody += item.disclaimerBody;
  });

  let acceptedDisclaimers = JSON.parse($.cookie('acceptedDisclaimers') || '[]');
  if (!acceptedDisclaimers.includes(nodeId)) {
    dialogBody = $('<div>' + dialogBody + '</div>').appendTo('body');
    Drupal.dialog(dialogBody, {
      title: dialogTitle,
      buttons: [
        {
          text: Drupal.t('Accept'),
          click: function () {
            acceptedDisclaimers.push(nodeId);
            $.cookie('acceptedDisclaimers', JSON.stringify(acceptedDisclaimers));
            $(this).dialog('close');
          }
        },
        {
          text: Drupal.t('Decline'),
          click: function () {
            $(this).dialog('close');
          }
        }
      ]
    }).showModal();
  }
})(jQuery, Drupal, drupalSettings);

