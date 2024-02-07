<?php
function choice_menu_ux_builder_element()
{
    add_ux_builder_shortcode('choice_menu', array(
        'name' => __('Block Menu'),
        'category' => __('Content'),
        'priority' => 1,
        'options' => array(
            'text' => array(
                'type' => 'textfield',
                'heading' => 'Title',
                'default' => 'Your Title',
                'auto_focus' => true,
            ),
            'ids' => array(
                'type' => 'select',
                'heading' => 'Chọn Menu',
                'param_name' => 'ids',
                'config' => array(
                    'multiple' => false,
                    'placeholder' => 'Select..',
                    'termSelect' => array(
                        'post_type' => 'nav_menu',
                        'taxonomies' => 'nav_menu'
                    ),
                )
            ),
        ),
    ));
}

add_action('ux_builder_setup', 'choice_menu_ux_builder_element');

function choice_menu_shortcode($atts)
{
    extract(shortcode_atts(array(
        'text' => 'Your Title',
        'ids' => false, // Custom IDs
    ), $atts));

    ?>
    <?php
    if ($ids == false) {
        return;
    }

    $menuitems = wp_get_nav_menu_items($ids, array('order' => 'DESC'));
    $menuitems = buildTree($menuitems);
    ob_start();
    ?>
    <div class="block-menu block-menu-<?php echo $ids; ?>">
        <h4><?php echo $text; ?></h4>
        <ul class="menu border-none">
            <?php
            foreach ($menuitems as $item) {
                create_menu($item);
            }
            ?>
        </ul>

    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('choice_menu', 'choice_menu_shortcode');

function create_menu($item)
{
    $link = $item->url;
    $title = $item->title;
    $id = $item->ID;
    if (property_exists($item, 'child')) {
        $children = $item->child;
        ?>
        <li class="menu-item menu-item-<?php echo $id; ?> menu-has-children">
            <a href="<?php echo $link; ?>">
                <?php echo $title; ?>
            </a>
            <ul class="sub-menu">
                <?php
                foreach ($children as $child) {
                    create_menu($child);
                }
                ?>
            </ul>
        </li>
        <?php
    } else {
        ?>
        <li class="menu-item menu-item-<?php echo $id; ?>">
            <a href="<?php echo $link; ?>">
                <?php echo $title; ?>
            </a>
        </li>
        <?php
    }
}

function buildTree(array &$elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as &$element) {
        if ($element->menu_item_parent == $parentId) {
            $children = buildTree($elements, $element->ID);
            if ($children)
                $element->child = $children;
            $element->has_children = 1;
            $branch[$element->ID] = $element;
            unset($element);
        }
    }
    return $branch;
}