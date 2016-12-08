<?php

/**
 * Blastro crypto utility
 * 
 * @author George Averill
 */

class BlCrypto
{
	private $key = 'hello world 1234';
	private $cryptoCipher = MCRYPT_RIJNDAEL_128;
	private $cryptoMode = MCRYPT_MODE_CBC;
	
	// Key is ideally 128, 192, or 256 bits long. Odd sizes will be padded with
	// nulls by mcrypt. 256 bits is an absolute maximum length.
	public function setKey($key)
	{
		if (strlen($key) <= mcrypt_get_key_size($this->cryptoCipher, $this->cryptoMode))
		{
			$this->key = $key;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function pkcs_pad($data, $blockSize)
	{
		$length = strlen($data);
		$padding = $blockSize - ($length % $blockSize);
		
		return $data . str_repeat(chr($padding), $padding);
	}
	
	public function pkcs_unpad($data, $blockSize)
	{
		$dataLength = strlen($data);
		
		if ($dataLength <= 0)
			return $data;
		
		$paddingByte = $data[$dataLength - 1];
		$paddingLength = ord($paddingByte);
		
		if ($paddingLength > 0)
		{
			for ($i = $dataLength - 1; $i >= $dataLength - $paddingLength; $i--)
			{
				//print "> $i / $dataLength | $paddingLength == ".ord($data[$i])."\n";
				if ($i < 0 || $data[$i] !== $paddingByte)
				{
					$paddingLength = 0;
					break;
				}
			}
		}
		
		if ($paddingLength)
			return substr($data, 0, $dataLength - $paddingLength);
		else
			return $data;
	}
	
	public function encrypt($data)
	{
		try
		{
			$iv_size = mcrypt_get_iv_size($this->cryptoCipher, $this->cryptoMode);
			$block_size = mcrypt_get_block_size($this->cryptoCipher, $this->cryptoMode);
			
			$iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);
			
			$crc = crc32($data . $iv);
			
			$text = mcrypt_encrypt($this->cryptoCipher, $this->key, $this->pkcs_pad($data . pack('N', $crc), $block_size), $this->cryptoMode, $iv);
			
			return bin2hex($iv . $text);
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function decrypt($data)
	{
		try
		{
			$iv_size = mcrypt_get_iv_size($this->cryptoCipher, $this->cryptoMode);
			$block_size = mcrypt_get_block_size($this->cryptoCipher, $this->cryptoMode);
			
			if (!preg_match('/^[0-9a-f]+$/i', $data))
				return false;
			
			$data = pack('H*', $data);
			
			$iv = substr($data, 0, $iv_size);
			$text = substr($data, $iv_size);
			
			if (strlen($iv) < $iv_size)
				return false;
			
			//var_dump('iv:',$iv,'text:',$text,'key:'.$this->key);
			//var_dump(mcrypt_decrypt($this->cryptoCipher, $this->key, $text, $this->cryptoMode, $iv));
			
			$plaintextAndCrc = $this->pkcs_unpad(mcrypt_decrypt($this->cryptoCipher, $this->key, $text, $this->cryptoMode, $iv), $block_size);
			
			$plaintext = substr($plaintextAndCrc, 0, -4);
			$crc = substr($plaintextAndCrc, -4);
			
			//var_dump(bin2hex($plaintextAndCrc), bin2hex($plaintext), bin2hex($crc));
			//var_dump($plaintextAndCrc, $plaintext, $crc);
			
			$crcVerify = pack('N', crc32($plaintext . $iv));
			
			if ($crc === '' || $crcVerify === '' || $crc !== $crcVerify)
				//print "CRC mismatch: " . bin2hex($crc) . " vs. " . bin2hex($crcVerify) . "\n";
				return false;
			
			return $plaintext;
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function encryptObject($object)
	{
		try
		{
			return $this->encrypt(json_encode($object));
		}
		catch (Exception $e)
		{
			return false;
		}
	}
	
	public function decryptObject($object)
	{
		try
		{
			return json_decode($this->decrypt($object));
		}
		catch (Exception $e)
		{
			return false;
		}
	}
}
