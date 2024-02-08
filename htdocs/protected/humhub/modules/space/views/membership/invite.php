<?= \humhub\modules\space\widgets\InviteModal::widget([
    'model' => $model,
    'submitText' => Yii::t('SpaceModule.base', 'Send'),
    'submitAction' => $space->createUrl('/space/membership/invite'),
    'searchUrl' => $space->createUrl('/space/membership/search-invite')
]); ?>