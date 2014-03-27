<?php
    $collection = get_current_record('Collections', false);
    $collectionId = get_current_record('Collections',false)->id;
    $collectionTitle = strip_formatting(metadata('collection', array('Dublin Core', 'Title')));

    if ($collectionTitle == '') {
        $collectionTitle = __('[Untitled]');
    }
?>

<?php echo head(array('title'=> $collectionTitle, 'bodyclass' => 'collections show')); ?>

<div class="container">
    <h1><?php echo $collectionTitle; ?></h1>
    <div class="row">
        <div class="col-sm-3">
            <?php echo common('nav-collection'); ?>
        </div>
        <div class="col-sm-9">
            <?php
                $collections = get_records('collection', array(), 99);
                set_loop_records('collections', $collections);
                if (has_loop_records('collections')){
                    foreach (loop('collections') as $collection){
                        $thisCollectionTitle = metadata('collection', array('Dublin Core', 'Title'));
                        $items = get_records('Item', array('collection'=>$collection->id), 99);
                        set_loop_records('items', $items);
                        if (($collectionTitle === 'Conference' && $thisCollectionTitle !== 'Workshop') || 
                            ($collectionTitle === 'Workshop' && $thisCollectionTitle === 'Workshop')){
                            if (has_loop_records('items')){
                                echo metadata('collection', array('Dublin Core', 'Title'));
                                echo '<div class="row">';
                                foreach (loop('items') as $item){
                                    echo '<div class="col-sm-4">';
                            	    echo link_to_item();
                                    echo '</div>';
                            	}
                                echo '</div>';
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>

<?php echo foot(); ?>