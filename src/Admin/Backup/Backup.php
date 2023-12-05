<?php

namespace Jonashcr\Admin\Backup;

class Backup
{
    public function index()
    {
        require ADMIN_VIEW . '/backup/index.phtml';
    }

    public function backup()
    {
        $outputPath = $this->createBackup();

        if ($outputPath) {
            header("Location: /admin/backup?success=1&path=" . urlencode($outputPath));
        } else {
            header("Location: /admin/backup?error=1");
        }
        exit();
    }

    private function createBackup()
    {
        $host = 'blog-db-1';
        $username = 'blog_user';
        $password = '123456';
        $database = 'blog_db';

        $backupFolderPath = ROOT_PATH . '/src/Admin/download/dump';
        $outputPath = $backupFolderPath . '/backup_' . date('Y-m-d_H-i-s') . '.sql';

        if (!is_dir($backupFolderPath)) {
            mkdir($backupFolderPath, 0777, true);
        }

        $command = sprintf(
            'mysqldump -h%s -u%s -p%s %s > %s',
            $host,
            $username,
            $password,
            $database,
            $outputPath
        );

        exec($command, $output, $resultCode);
        
        if ($resultCode === 0) {
            return str_replace(ROOT_PATH, '', $outputPath);
        } else {
            return false;
        }
    }
}
