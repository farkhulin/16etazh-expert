<?php

/**
 * @file
 * Contains \Drupal\etazhmodule\Plugin\Block\EtazhObjectsBlock.
 */

// Пространство имён для нашего блока.
namespace Drupal\etazhmodule\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Block(
 *   id = "etazh_objects_block",
 *   admin_label = @Translation("Etazh objects block"),
 * )
 */

class EtazhObjectsBlock extends BlockBase {
  /**
   * Генерируем и выводим содержимое блока.
   *
   * {@inheritdoc}
   */
  public function build() {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->addField('nfd', 'nid');
    $query->addField('nfd', 'title');
    $query->addField('nfd', 'created');
    $query->addField('nfoe', 'field_object_expertise_value');
    $query->join('node__field_object_expertise', 'nfoe', 'nfoe.entity_id = nfd.nid');
    if (isset($_SESSION['etazhblock-objectid']) && is_numeric($_SESSION['etazhblock-objectid'])) {
      $query->condition('nfd.nid', $_SESSION['etazhblock-objectid']);
    }
    if (isset($_SESSION['etazhblock-expertise']) && is_numeric($_SESSION['etazhblock-expertise']) && $_SESSION['etazhblock-expertise'] == 0) {
      $query->condition('nfoe.field_object_expertise_value', 'нет');
    }
    $query->orderBy('nfd.created', 'DESC');
    $result = $query->execute()->fetchAll();

    $objectList = '';
    $host = \Drupal::request()->getHost();

    foreach ($result as $node) {
      $objectList .= '<div class="object-row"><span class="object-arrow">&#8594;</span><span class="object-info">#'.$node->nid.' <a href="https://'.$host.'/expert/node/'.$node->nid.'">'.$node->title.'</a> ('.date('d.m.Y', $node->created).') Экспертиза: '.$node->field_object_expertise_value.'</span></div>';
    }

    if ($objectList == '') {
      $objectList = '<div class="object-row">объектов не обнаружено</div>';
    }

    $objectList .= '<div class="separator"></div>';

    $form = \Drupal::formBuilder()->getForm('Drupal\etazhmodule\Form\ObjectsForm');

    $content[] = $form;
    $content['add']['#markup'] = '<a href="https://'.$host.'/expert/objects" class="more-filter">Расширенная верcия фильтра</a>';
    $content['results'] = [
      '#markup' => $objectList,
    ];

    return $content;
  }
}
