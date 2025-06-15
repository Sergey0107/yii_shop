<?php

namespace backend\models;
use Yii;
use yii\db\Exception;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $img
 * @property int $price
 * @property int|null $quantity
 * @property int|null $is_active
 * @property int $size_id
 * @property int $type_id
 * @property int $country_id
 * @property int $color_id
 * @property int $material_id
 * @property bool $is_new
 * @property bool $is_popular
 * @property int $old_price
 * @property int $weight
 *
 * @property Color $color
 * @property Country $country
 * @property Material $material
 * @property Size $size
 * @property Type $type
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile Загруженный файл изображения
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    public static function getProductsCount(): bool|int|string|null
    {
        return self::find()->count();
    }

    public static function getActiveProductsCount()
    {
        return self::find()->where(['is_active' => 1])->count();
    }

    public static function getNotActiveProductsCount()
    {
        return self::find()->where(['is_active' => 0])->count();
    }

    public static function getTotalSum()
    {
        return self::find()->sum('price');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'img'], 'default', 'value' => null],
            [['is_active', 'is_new', 'is_popular'], 'default', 'value' => 0],
            [['name', 'price', 'size_id', 'weight', 'type_id', 'country_id', 'color_id', 'material_id'], 'required'],
            [['price', 'quantity', 'is_active', 'size_id', 'type_id', 'country_id', 'color_id', 'material_id', 'is_new', 'is_popular', 'old_price'], 'integer'],
            [['name', 'description', 'img'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::class, 'targetAttribute' => ['material_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::class, 'targetAttribute' => ['size_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'], // Валидация изображений
        ];
    }

    public function upload(): bool
    {
        if ($this->imageFile) {
            $uploadDir = Yii::getAlias('@webroot/uploads/product/');

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '.' . $this->imageFile->extension;
            $filePath = $uploadDir . $fileName;

            if ($this->imageFile->saveAs($filePath)) {
                if ($this->img){
                    $this->deleteImage($this->img);
                }
                $this->img = $fileName;
                return true;
            }
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'img' => 'Изображение',
            'price' => 'Цена',
            'quantity' => 'Количество',
            'is_active' => 'Активен',
            'size_id' => 'Размер',
            'type_id' => 'Тип',
            'country_id' => 'Страна',
            'color_id' => 'Цвет',
            'material_id' => 'Материал',
            'is_new' => 'Новинка',
            'is_popular' => 'Популярный',
            'old_price' => 'Цена до скидки',
            'weight' => 'Вес, кг'
        ];
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * Gets query for [[Material]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::class, ['id' => 'material_id']);
    }

    /**
     * Gets query for [[Size]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::class, ['id' => 'size_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function deleteImage($fileName)
    {
        $filePath = Yii::getAlias('@webroot/uploads/product/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        } else {
            return false;
        }
    }

    public function getProductProperties()
    {
        return $this->hasMany(ProductProperty::class, ['product_id' => 'id']);
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['id' => 'property_id'])
            ->viaTable('product_property', ['product_id' => 'id']);
    }

    public function getPropertyValues()
    {
        return $this->hasMany(PropertyValue::class, ['id' => 'value_id'])
            ->via('productProperties');
    }

    public function inUserOrder(): bool
    {
       $userId = Yii::$app->user->id;
       $order = Order::findOne(['user_id' => $userId, 'status' => Order::STATUS_DRAFT]);
       if (!$order) {
           return false;
       }
       $orderProduct = OrderProducts::findOne(['order_id' => $order->id, 'product_id' => $this->id]);
       if (!$orderProduct) {
           return false;
       }

       return true;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function reserveProductForOrder()
    {
        $this->quantity -= 1;
        if (!$this->save(false)) {
            throw new \Exception('Ошибка при резервировании товара в заказ');
        }
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function returnProductToWarehouse($count = null): void
    {
        $this->quantity += ($count ?? 1);
        if (!$this->save(false)) {
            throw new \Exception('Ошибка при возврате товара на склад');
        }

    }

    public function getRating()
    {
        $averageRating = Review::find()
            ->where(['product_id' => $this->id])
            ->average('rating');

        return $averageRating !== null ? round((float)$averageRating, 1) : 0;
    }

    public function getCountReview(): bool|int|string|null
    {
        return Review::find()->where(['product_id' => $this->id])->count();
    }

}
