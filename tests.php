<?php

trait Tests
{
    public function isAccessible(string $baseDir, string $file) {
        return file_exists("{$baseDir}/{$file}.php");
    }
}
