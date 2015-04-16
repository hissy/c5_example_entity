<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if ($controller->getTask() == 'add' ||
    $controller->getTask() == 'edit' ||
    $controller->getTask() == 'submit') { ?>

    <form method="post" action="<?=$view->action('submit')?>">
        <?php echo $token->output('submit') ?>
        <?php echo $form->hidden('eID', $eID) ?>
        <fieldset>
            <legend><?php echo t('Detail') ?></legend>
            <div class="form-group">
                <?php echo $form->label('name', t('Name')) ?>
                <?php echo $form->text('name', $name) ?>
            </div>
        </fieldset>
        <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <a href="<?php echo URL::to('/dashboard/entities/search') ?>" class="btn btn-default pull-left"><?=t('Cancel')?></a>
            <?php if (isset($eID)) { ?>
            <?php echo $form->submit('save', t('Save'), array('class' => 'btn btn-primary pull-right'))?>
            <?php } else { ?>
            <?php echo $form->submit('add', t('Add'), array('class' => 'btn btn-primary pull-right'))?>
            <?php } ?>
        </div>
        </div>
    </form>

    <?php if (isset($eID)) { ?>
    <div class="ccm-dashboard-header-buttons">
        <button data-dialog="delete-entity" class="btn btn-danger"><?php echo t("Delete")?></button>
    </div>

    <div style="display: none">
        <div id="ccm-dialog-delete-entity" class="ccm-ui">
            <form method="post" class="form-stacked" action="<?=$view->action('delete')?>">
                <?php echo $token->output('delete') ?>
                <?php echo $form->hidden('eID', $eID) ?>
                <p><?=t('Are you sure? This action cannot be undone.')?></p>
            </form>
            <div class="dialog-buttons">
                <button class="btn btn-default pull-left" onclick="jQuery.fn.dialog.closeTop()"><?=t('Cancel')?></button>
                <button class="btn btn-danger pull-right" onclick="$('#ccm-dialog-delete-entity form').submit()"><?=t('Delete')?></button>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    $('button[data-dialog=delete-entity]').on('click', function() {
        jQuery.fn.dialog.open({
            element: '#ccm-dialog-delete-entity',
            modal: true,
            width: 320,
            title: '<?=t("Delete Entity")?>',
            height: 'auto'
        });
    });
    </script>
    <?php } ?>

<?php } else { ?>

    <?php if (count($entries)) { ?>

    <div class="ccm-dashboard-content-full">
        <form role="form" action="<?php echo $controller->action('view')?>" class="form-inline ccm-search-fields">
            <div class="ccm-search-fields-row">
                <div class="form-group">
                    <?php echo $form->label('keywords', t('Search'))?>
                    <div class="ccm-search-field-content">
                        <div class="ccm-search-main-lookup-field">
                            <i class="fa fa-search"></i>
                            <?php echo $form->search('keywords', array('placeholder' => t('Keywords')))?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ccm-search-fields-submit">
                <button type="submit" class="btn btn-primary pull-right"><?php echo t('Search')?></button>
            </div>
        </form>

        <div data-search-element="results">
            <div class="table-responsive">
                <table class="ccm-search-results-table">
                    <thead>
                        <tr>
                            <th><span><?php echo t('ID') ?></span></th>
                            <th><span><?php echo t('Name') ?></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($entries as $e) { ?>
                        <tr>
                            <td><?php echo h($e->getID()) ?></td>
                            <td>
                                <a href="<?php echo URL::to('/dashboard/entities/search/edit', $e->getID()) ?>">
                                    <?php echo h($e->getName()) ?>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="ccm-search-results-pagination">
            <?php print $pagination->renderDefaultView();?>
        </div>
    </div>

    <?php } else { ?>

    <p><?php echo t("No results found.") ?></p>

    <?php } ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo URL::to('/dashboard/entities/search/add')?>" class="btn btn-primary"><?php echo t("Add")?></a>
    </div>

<?php }
