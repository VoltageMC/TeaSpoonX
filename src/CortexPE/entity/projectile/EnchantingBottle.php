<?php

/**
 *
 * MMP""MM""YMM               .M"""bgd
 * P'   MM   `7              ,MI    "Y
 *      MM  .gP"Ya   ,6"Yb.  `MMb.   `7MMpdMAo.  ,pW"Wq.   ,pW"Wq.`7MMpMMMb.
 *      MM ,M'   Yb 8)   MM    `YMMNq. MM   `Wb 6W'   `Wb 6W'   `Wb MM    MM
 *      MM 8M""""""  ,pm9MM  .     `MM MM    M8 8M     M8 8M     M8 MM    MM
 *      MM YM.    , 8M   MM  Mb     dM MM   ,AP YA.   ,A9 YA.   ,A9 MM    MM
 *    .JMML.`Mbmmd' `Moo9^Yo.P"Ybmmd"  MMbmmd'   `Ybmd9'   `Ybmd9'.JMML  JMML.
 *                                     MM
 *                                   .JMML.
 * This file is part of TeaSpoon.
 *
 * TeaSpoon is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TeaSpoon is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with TeaSpoon.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author CortexPE
 * @link https://CortexPE.xyz
 *
 */

declare(strict_types = 1);

namespace CortexPE\entity\projectile;

use CortexPE\level\particle\SpellParticle;
use pocketmine\entity\{
	Entity, projectile\Throwable
};

class EnchantingBottle extends Throwable {
	const NETWORK_ID = self::XP_BOTTLE;
	const RAND_POS_X = [0, -0.1];
	const RAND_POS_Y = [-0.2];
	const RAND_POS_Z = [0, -0.1];
	public $spawnedOrbs = false;

	public function onUpdate(int $currentTick): bool{
		if($this->isCollided || $this->age > 1200 && !$this->spawnedOrbs){
			$rand = mt_rand(1, 3);
			$this->getLevel()->addParticle(new SpellParticle($this, 46, 82, 153));
			for($c = 0; $c <= $rand; $c++){
				$randomX = self::RAND_POS_X[array_rand(self::RAND_POS_X)];
				$randomY = self::RAND_POS_Y[array_rand(self::RAND_POS_Y)];
				$randomZ = self::RAND_POS_Z[array_rand(self::RAND_POS_Z)];

				$nbt = Entity::createBaseNBT($this->add($randomX, $randomY, $randomZ));
				$nbt->setLong("Experience", mt_rand(1, 4));
				$orb = Entity::createEntity("XPOrb", $this->getLevel(), $nbt);
				$orb->spawnToAll();
			}
			$this->kill();
		}

		return parent::onUpdate($currentTick);
	}

	public function onCollideWithEntity(Entity $entity){
		return;
	}
}