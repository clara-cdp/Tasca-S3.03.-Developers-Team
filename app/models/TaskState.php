<?php

enum TaskState: string
{
    case PENDING = 'pending';
    case ONGOING = 'ongoing';
    case FINISHED = 'finished';
}
