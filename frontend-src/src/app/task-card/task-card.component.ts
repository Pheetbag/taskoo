import {Component, Input, OnInit, Output, EventEmitter} from '@angular/core';
import axios from 'axios';
import TaskInterface from './../../TaskInterface';

@Component({
  selector: 'app-task-card',
  templateUrl: './task-card.component.html',
  styleUrls: ['./task-card.component.css']
})
export class TaskCardComponent {

  constructor() { }

  title: string = null;
  description: string = null;

  submitting = false;
  onEditMode = false;

  @Input() task: TaskInterface;
  @Output() deletedResult = new EventEmitter<TaskInterface>();
  @Output() updatedResult = new EventEmitter<TaskInterface>();

  editTask(): void {
    this.title = this.task.title;
    this.description = this.task.description;
    this.onEditMode = true;
  }

  async deleteTask(): Promise<void> {
    this.submitting = true;
    const res = await axios.delete(`/api/tasks/${this.task.id}/`);
    this.deletedResult.emit(this.task);
    this.submitting = false;
  }

  async onSubmit(): Promise<void> {
    this.submitting = true;

    const res = await axios.patch(`/api/tasks/${this.task.id}/`, {
      title: this.title,
      description: this.description,
      position_index: this.task.position_index
    });

    this.submitting = false;
    this.onEditMode = false;

    this.task.title = this.title;
    this.task.description = this.description;

    this.title = null;
    this.description = null;


    this.updatedResult.emit(res.data);
  }

}
