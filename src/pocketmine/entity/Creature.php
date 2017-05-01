<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\level\Level;
use pocketmine\math\Vector3;

abstract class Creature extends Living{

	public $attackingTick = 0;

	public function onUpdate($tick){
		if(!$this instanceof Human){
			if($this->attackingTick > 0){
				$this->attackingTick--;
			}
			if(!$this->isAlive() and $this->hasSpawned){
				++$this->deadTicks;
				if($this->deadTicks >= 20){
					$this->despawnFromAll();
				}
				return true;
			}
			if($this->isAlive()){

				$this->motionY -= $this->gravity;

				$this->move($this->motionX, $this->motionY, $this->motionZ);

				$friction = 1 - $this->drag;

				if($this->onGround and (abs($this->motionX) > 0.00001 or abs($this->motionZ) > 0.00001)){
					$friction = $this->getLevel()->getBlock($this->temporalVector->setComponents((int) floor($this->x), (int) floor($this->y - 1), (int) floor($this->z) - 1))->getFrictionFactor() * $friction;
				}

				$this->motionX *= $friction;
				$this->motionY *= 1 - $this->drag;
				$this->motionZ *= $friction;

				if($this->onGround){
					$this->motionY *= -0.5;
				}

				$this->updateMovement();
			}
		}
		parent::entityBaseTick();
		return parent::onUpdate($tick);
	}

	public function willMove($distance = 36){
		foreach($this->getViewers() as $viewer){
			if($this->distance($viewer->getLocation()) <= $distance) return true;
		}
		return false;
	}

	public function attack($damage, EntityDamageEvent $source){
		parent::attack($damage, $source);
		if(!$source->isCancelled() and $source->getCause() == EntityDamageEvent::CAUSE_ENTITY_ATTACK){
			$this->attackingTick = 20;
		}
	}

	/**
	 * @param Level   $level
	 * @param Vector3 $v3
	 * @param bool    $hate
	 * @param bool    $reason
	 * @return bool|float|string
	 * 判断某坐?是否可以行走
	 * 并?出原因
	 */
	public function ifjump(Level $level, Vector3 $v3, $hate = false, $reason = false){  //boybook Y?算法核心函数
		$x = floor($v3->getX());
		$y = floor($v3->getY());
		$z = floor($v3->getZ());

		//echo ($y." ");
		if($this->whatBlock($level, new Vector3($x, $y, $z)) == "air"){
			//echo "前方空气 ";
			if($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "block" or new Vector3($x, $y - 1, $z) == "climb"){  //方?
				//echo "考?向前 ";
				if($this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "block" or $this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "half" or $this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "high"){  //上方一格被堵住了
					//echo "上方?住 \n";
					if($reason) return 'up!';
					return false;  //上方?住
				}else{
					//echo "GO向前走 \n";
					if($reason) return 'GO';
					return $y;  //向前走
				}
			}elseif($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "water"){  //水
				//echo "下水游泳 \n";
				if($reason) return 'swim';
				return $y - 1;  //降低一格向前走（下水游泳）
			}elseif($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "half"){  //半?
				//echo "下到半? \n";
				if($reason) return 'half';
				return $y - 0.5;  //向下跳0.5格
			}elseif($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "lava"){  //岩?
				//echo "前方岩? \n";
				if($reason) return 'lava';
				return false;  //前方岩?
			}elseif($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "air"){  //空气
				//echo "考?向下跳 ";
				if($this->whatBlock($level, new Vector3($x, $y - 2, $z)) == "block"){
					//echo "GO向下跳 \n";
					if($reason) return 'down';
					return $y - 1;  //向下跳
				}else{ //前方?崖
					//echo "前方?崖 \n";
					if($reason) return 'fall';
					if($hate === false){
						return false;
					}else{
						return $y - 1;  //向下跳
					}
				}
			}
		}elseif($this->whatBlock($level, new Vector3($x, $y, $z)) == "water"){  //水
			//echo "正在水中";
			if($this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "water"){  //上面?是水
				//echo "向上游 \n";
				if($reason) return 'inwater';
				return $y + 1;  //向上游，防溺水
			}elseif($this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "block" or $this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "half"){  //上方一格被堵住了
				if($this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "block" or $this->whatBlock($level, new Vector3($x, $y - 1, $z)) == "half"){  //下方一格被也堵住了
					//echo "上下都被?住 \n";
					if($reason) return 'up!_down!';
					return false;  //上下都被?住
				}else{
					//echo "向下游 \n";
					if($reason) return 'up!';
					return $y - 1;  //向下游，防?住
				}
			}else{
				//echo "游泳ing... \n";
				if($reason) return 'swim...';
				return $y;  //向前游
			}
		}elseif($this->whatBlock($level, new Vector3($x, $y, $z)) == "half"){  //半?
			//echo "前方半? \n";
			if($this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "block" or $this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "half" or $this->whatBlock($level, new Vector3($x, $y + 1, $z)) == "high"){  //上方一格被堵住了
				//return false;  //上方?住
			}else{
				if($reason) return 'halfGO';
				return $y + 0.5;
			}

		}elseif($this->whatBlock($level, new Vector3($x, $y, $z)) == "lava"){  //岩?
			//echo "前方岩? \n";
			if($reason) return 'lava';
			return false;
		}elseif($this->whatBlock($level, new Vector3($x, $y, $z)) == "high"){  //1.5格高方?
			//echo "前方?? \n";
			if($reason) return 'high';
			return false;
		}elseif($this->whatBlock($level, new Vector3($x, $y, $z)) == "climb"){  //梯子
			//echo "前方梯子 \n";
			//return $y;
			if($reason) return 'climb';
			if($hate){
				return $y + 0.7;
			}else{
				return $y + 0.5;
			}
		}else{  //考?向上
			//echo "考?向上 ";
			if($this->whatBlock($level, new Vector3($x, $y + 1, $z)) != "air"){  //前方是面?
				//echo "前方是? \n";
				if($reason) return 'wall';
				return false;
			}else{
				if($this->whatBlock($level, new Vector3($x, $y + 2, $z)) == "block" or $this->whatBlock($level, new Vector3($x, $y + 2, $z)) == "half" or $this->whatBlock($level, new Vector3($x, $y + 2, $z)) == "high"){  //上方?格被堵住了
					//echo "2格?被堵 \n";
					if($reason) return 'up2!';
					return false;
				}else{
					//echo "GO向上跳 \n";
					if($reason) return 'upGO';
					return $y + 1;  //向上跳
				}
			}
		}
		return false;
	}

	public function whatBlock(Level $level, $v3){  //boybook的y?判断法 核心 什?方?？
		$id = $level->getBlockIdAt($v3->x, $v3->y, $v3->z);
		$damage = $level->getBlockDataAt($v3->x, $v3->y, $v3->z);
		switch($id){
			case 0:
			case 6:
			case 27:
			case 30:
			case 31:
			case 37:
			case 38:
			case 39:
			case 40:
			case 50:
			case 51:
			case 63:
			case 66:
			case 68:
			case 78:
			case 111:
			case 141:
			case 142:
			case 171:
			case 175:
			case 244:
			case 323:
				//透明方?
				return "air";
				break;
			case 8:
			case 9:
				//水
				return "water";
				break;
			case 10:
			case 11:
				//岩?
				return "lava";
				break;
			case 44:
			case 158:
				//半?
				if($damage >= 8){
					return "block";
				}else{
					return "half";
				}
				break;
			case 64:
				//?
				//var_dump($damage." ");
				//TODO 不知如何判断?是否??，因?以下条件永??足
				if(($damage & 0x08) === 0x08){
					return "air";
				}else{
					return "block";
				}
				break;
			case 85:
			case 107:
			case 139:
				//1.5格高的无法跳?物
				return "high";
				break;
			case 65:
			case 106:
				//可攀爬物
				return "climb";
				break;
			default:
				//普通方?
				return "block";
				break;
		}
	}

	/**
	 * @param $mx
	 * @param $mz
	 * @return float|int
	 * ?取yaw角度
	 */
	public function getMyYaw($mx, $mz){  //根据motion?算?向角度
		//?向?算
		if($mz == 0){  //斜率不存在
			if($mx < 0){
				$yaw = -90;
			}else{
				$yaw = 90;
			}
		}else{  //存在斜率
			if($mx >= 0 and $mz > 0){  //第一象限
				$atan = atan($mx / $mz);
				$yaw = rad2deg($atan);
			}elseif($mx >= 0 and $mz < 0){  //第二象限
				$atan = atan($mx / abs($mz));
				$yaw = 180 - rad2deg($atan);
			}elseif($mx < 0 and $mz < 0){  //第三象限
				$atan = atan($mx / $mz);
				$yaw = -(180 - rad2deg($atan));
			}elseif($mx < 0 and $mz > 0){  //第四象限
				$atan = atan(abs($mx) / $mz);
				$yaw = -(rad2deg($atan));
			}else{
				$yaw = 0;
			}
		}

		$yaw = -$yaw;
		return $yaw;
	}

	/**
	 * @param Vector3 $from
	 * @param Vector3 $to
	 * @return float|int
	 * ?取pitch角度
	 */
	public function getMyPitch(Vector3 $from, Vector3 $to){
		$distance = $from->distance($to);
		$height = $to->y - $from->y;
		if($height > 0){
			return -rad2deg(asin($height / $distance));
		}elseif($height < 0){
			return rad2deg(asin(-$height / $distance));
		}else{
			return 0;
		}
	}
}