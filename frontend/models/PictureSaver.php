<?
namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class PictureSaver extends Model
{
    public $imageFile, $imageName;

    public function rules()
    {
        return [
            ['imageFile', 'file', 'skipOnEmpty' => false,  'extensions' => 'jpg'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $dir = Yii::getAlias("@frontend/web/uploads/");
            $this->imageFile->saveAs($dir . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            $this->imageName = $this->imageFile->baseName . '.' . $this->imageFile->extension;
            return true;
        } else {
            return false;
        }
    }
}