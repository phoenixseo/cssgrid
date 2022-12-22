<?php
/**
 * Prepares variables for view template.
 *
 * Default template: views-view-cssgrid.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - view: A ViewExecutable object.
 *   - rows: The raw row data.
 */
function template_preprocess_views_view_cssgrid(&$variables) {
    $view = $variables['view'];

    $options = $variables['view']->style_plugin->options;
    $variables['options'] = $options;

    $rows = $variables['rows'];
 }
