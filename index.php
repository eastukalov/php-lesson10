<?php
    interface MoveAble
    {
        public function start ();
        public function stop ();
    }

    interface OwnerAble
    {
        public function getOwner();
        public function setOwner($owner);
    }

    interface TypeAble
    {
        public function getType();
        public function setType($type);
    }

    interface OnOffAble
    {
        public function on ();
        public function off ();
    }

    interface BrandGetAble
    {
        public function getBrand();
    }

    interface ModelGetAble
    {
        public function getModel();
    }

    interface MaterialGetAble
    {
        public function getMaterial();
    }

    interface GenderAble
    {
        public function getGender();
        public function setGender($gender);
    }

    interface BreedAble
    {
        public function getBreed();
        public function setBreed($breed);
    }

    interface WildGetAble
    {
        public function getWild();
    }

	class TransportClass implements MoveAble, TypeAble
    {
        private $brand;
        private $model;
        private $move = false;
        private $color;
        protected $type;

        public function __construct ($brand, $model, $color)
        {
            $this->brand = $brand;
            $this->model = $model;
            $this->color = $color;
        }

        public function start ()
        {
            $this->move = true;
            echo '<p>Поехали</p>';
        }

        public function stop ()
        {
            $this->move = false;
            echo '<p>Остановились</p>';
        }

        public function getType()
        {
            return $this->type;
        }

        public function setType($type)
        {
            $this->type = $type;
            return $this;
        }

    }

    class CarClass extends TransportClass implements OwnerAble
	{
		private $owner;
		protected $type='car';

        public function getOwner()
        {
            return '<p>Владелец: ' . $this->owner . '</p>';
        }

        public function setOwner($owner)
        {
            $this->owner = $owner;
            return $this;
        }

	}

	$carBMV = new CarClass('BMW', 'Z4', 'white');
	$carAudi = new CarClass('Audi', 'A5', 'black');
	$carAudi->start();
	$carAudi->stop();
	$carAudi->setOwner('Stukalov');
	echo $carAudi->getOwner();

    class HomeAppliancesClass implements OnOffAble, BrandGetAble, ModelGetAble, OwnerAble
    {
        private $brand;
        private $model;
        private $onOff = false;
        private $owner;

        public function __construct ($brand, $model)
        {
            $this->brand = $brand;
            $this->model = $model;
        }

        public function on ()
        {
            $this->onOff = true;
            echo '<p>Включен</p>';
        }

        public function off ()
        {
            $this->onOff = false;
            echo '<p>Выключен</p>';
        }

        public function getOnOff()
        {
            return $this->onOff;
        }

        public function getBrand()
        {
            return $this->brand;
        }

        public function getModel()
        {
            return $this->model;
        }

        public function getOwner()
        {
            return '<p>Владелец: ' . $this->owner . '</p>';
        }

        public function setOwner($owner)
        {
            $this->owner = $owner;
            return $this;
        }

    }

	class TVClass extends HomeAppliancesClass
	{
		private $type;

		private $channel;


        public function __construct($brand , $model, $type)
        {
            parent::__construct($brand, $model);
            $this->type = $type;
        }

        public function changeChannel ($channel) {
		 	
			if ($this->getOnOff()) {
				$this->channel = $channel;
				echo "<p>Канал: $this->channel</p>";
			}
		}

	}

	$tvSony = new TVClass('Sony', 'trinetron', 'lcd');
	$tvSamsung = new TVClass('Samsung', 'PDP F4000', 'plasma' );

	$tvSony->on();
	$tvSony->changeChannel(5);
	$tvSony->off();

	class WritingInstruments implements MaterialGetAble, TypeAble
    {
        private $material;
        private $type;

        public function __construct ($material)
        {
            $this->material = $material;
        }

        public function getMaterial()
        {
            return $this->material;
        }

        public function getType()
        {
            return $this->type;
        }

        public function setType($type)
        {
            $this->type = $type;
            return $this;
        }

    }

	class BallpointPenClass extends WritingInstruments
	{
        private $color;

        public function __construct($material, $color)
        {
            parent::__construct($material);
            $this->color = $color;
            parent::setType('BallpointPen');
        }

		public function changeColor ($color)
		{
			$this->color = $color;
			echo "<p>Стержень заменен на $this->color цвет</p>";
		}

	}

	$steelPen = new BallpointPenClass('steel', 'blue');
	$plasticPen = new BallpointPenClass('plastic', 'black');

	$plasticPen->changeColor('red');

	class BirdClass implements GenderAble, BreedAble
    {
        private $gender;
        private $state = 'спит';
        private $breed;

        public function __construct ($breed, $gender)
        {
            $this->breed = $breed;
            $this->gender = $gender;
        }

        public function getGender()
        {
            return $this->gender;
        }

        public function setGender($gender)
        {
            $this->gender = $gender;
            return $this;
        }

        public function getBreed()
        {
            return $this->breed;
        }

        public function setBreed($breed)
        {
            $this->breed = $breed;
            return $this;
        }

        public function changeState ($state)
        {
            $this->state = $state;
            echo "<p>Утка $this->state</p>";
        }

    }

	class DuckClass extends BirdClass implements WildGetAble
	{
        private $wild;

        public function __construct($wild)
        {
            $this->wild = $wild;
            parent::__construct (parent::getBreed(), parent::getGender());
        }

        public function getWild()
        {
            return $this->wild;
        }

    }

	$duckMandarin = new DuckClass('wild', 'Mandarin', 'male');
	$duckGrebe = new DuckClass('home', 'Grebe', 'female' );
	$duckMandarin->changeState('плывет');

//Товар сам по себе замечательно подходит на роль суперкласса
	class ProductClass
	{
		private $price;
		private $discount = 0;
		private $name;

		public function __construct ($name, $price, $discount=0)
		{
			$this->name = $name;
			$this->price = $price;
			$this->discount = $discount;
		}

		public function changePrice ($price, $discount=0)
		{
			if ($price) {
				$this->price = $discount ? ($price - $price * $discount / 100) : $price;
				echo "Новая цена: $this->price";
			}
		}
	}

	$productBread = new ProductClass('Bread', 100);
	$productJacket = new ProductClass('Jacket', 1000);

	$productJacket->changePrice(1000, 20);



    interface WeightAble
    {
        public function getWeight();
        public function setWeight($weight);
    }

    interface PriceAble
    {
        public function setPrice($price);
        public function getPrice ();
    }

	abstract class ProductDopClass implements PriceAble
    {
        private $brand;
        private $name;
        private $price;
        protected $discount = 10;
        private $delivery = 250;
        private $deliveryDiscount = 300;
        protected $weight = 0;

        public function __construct($brand, $name, $price)
        {
            $this->brand = $brand;
            $this->name = $name;
            $this->price = $price;
        }

        public function setPrice($price)
        {
            $this->price = $price;
            return $this;
        }

        public function getPrice ()
        {
            if ($this->weight > 10 || ($this->weight === 0 & $this->discount > 0)) {
                $this->price = $this->price * (1 - $this->discount / 100);
                return "<p>Цена: $this->price, скидка: $this->discount %, доставка: $this->deliveryDiscount</p>";
            }
            else {
                return "<p>Цена: $this->price, доставка: $this->delivery</p>";
            }

        }

    }

    class FoodClass extends ProductDopClass implements WeightAble
    {
        protected $weight;

        public function __construct($brand, $name, $price, $weight)
        {
            parent::__construct($brand, $name, $price);
            $this->weight = $weight;
        }

        public function getWeight()
        {
            return $this->weight;
        }

        public function setWeight($weight)
        {
            $this->weight = $weight;
            return $this;
        }

    }

    class ClothesClass extends ProductDopClass
    {
        protected $discount = 0;
    }

    class MobilePhone extends ProductDopClass
    {

    }

    $food = new FoodClass('mikayan', 'sausage', 1000, 11);
	echo $food->getPrice();
	$mobilePhone = new MobilePhone('Sony', 'Z50', 5000);
    echo $mobilePhone->getPrice();
    $clothesClass = new ClothesClass('jeans', 'Brax', 3000);
    echo $clothesClass->getPrice();