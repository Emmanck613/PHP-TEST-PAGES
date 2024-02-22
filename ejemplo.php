<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
$this->title = 'Contact Form';
use yii\db\ActiveRecord;

class Forms extends ActiveRecord{
    /**
 * @inheritdoc
 */
    public static function tableName(){
        return 'forms';
    }

    public function rules()
    { //start
        return [
            [['name','email','theme','title','content'], 'required'], //todos los campos son requeridos
            ['email', 'email'], //validar correo
            [['name'],'string', 'max' => 50], //validar longitud
            [['email'], 'string', 'max' => 50], //validar longitud
            [['theme'], 'string', 'max' => 50], //validar longitud
            [['title'], 'string', 'max' => 50], //validar longitud
            [['content'], 'string', 'max' => 50], //validar longitud
            
        ];
    } //end
 }    

 //controller area
use yii\web\Controller;
use Yii;

class UserFormController extends Controller {

    public function actionForms()
    {
        $model = new Forms();
        /**
        * Primero checamos que la solicitud es post y luego almacena los datos en la tabla
        * de la BD.
        */
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        /**
        *Checamos que el formulario fue admitido y se despliega su vista junto 
        *con los datos del model
        */  
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->render('ejemplo', [
                'model' => $model,
            ]);
        /**
        *Si la solicitud no fue un post, solo se despliega la vista y el model.
        *Se regresa el model para que el usuario pueda corregir los errores.
        */     
        } else {
            return $this->render('ejemplo', [
                'model' => $model,
            ]);
        }
    }
}

?>

<h1><?= Html::encode($this->title) ?></h1>
<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
<div class="row">
   <div class="col-lg-5">
       <div class="panel panel-default">
           <div class="panel-heading">Message Sent</div>
           <div class="panel-body">
               <p><b>Nombre:</b> <?=$model->name?> </p>
               <p><b>Email:</b> <?=$model->email?> </p>
               <p><b>Tema:</b> <?=$model->content?> </p>
           </div>
       </div>
       <div class="alert alert-success">
           Thank you for contacting us. We will respond to you as soon as possible.
       </div>
   </div>
</div>
<!-- 
    A continuacion se agrega un formulario a llenar en caso que el formulario esta vacio
-->
<?php else: ?>
<div class="row">
           <div class="col-lg-5">
               <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                   <?= $form->field($model, 'name')->label($label="Nombre") ?>
                   <?= $form->field($model, 'email')->label($label="Correo") ?>
                   <?= $form->field($model, 'theme')->label($label="Tema") ?>
                   <?= $form->field($model, 'title')->label($label="Titulo") ?>
                   <?= $form->field($model, 'content')->label($label="Contenido")->dropDownList(
                   $options = [
                                'Multimedia' => ['Multimedia' => 'Videos, Infografias, Podcast'],
                                'Noticia' => ['Noticia' => 'Noticias, Articulos, Reportes'],
                                'Evento' => ['Evento' => 'Conferencias, Talleres, Congresos, etc']
                            ])?>

                   <div class="form-group">
                       <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                   </div>
               <?php ActiveForm::end(); ?>
           </div>
       </div>
<?php endif; ?>