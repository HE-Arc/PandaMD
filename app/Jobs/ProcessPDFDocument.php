<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ProcessPDFDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = new Process(array("pandoc", "md_files/$this->token.md", "-o", "pdf_files/$this->token.pdf", "--template", "eisvogel", "--number-sections", "--pdf-engine", "/bin/pdflatex"));
        $process->run();
        if(!$process->isSuccessful()){
            throw new ProcessFailedException($process);
        }
    }
}
