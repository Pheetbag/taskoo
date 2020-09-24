import {Component, Input, Output, EventEmitter} from '@angular/core';
import axios from 'axios';
import TaskInterface from '../../TaskInterface';

@Component({
  selector: 'app-creation-form',
  templateUrl: './creation-form.component.html',
  styleUrls: ['./creation-form.component.css']
})
export class CreationFormComponent {

  constructor() { }

  title: string = null;
  description: string = null;

  @Input() lastTaskPosition: number;
  @Output() createdResult = new EventEmitter<TaskInterface>();

  submitting = false;

  async onSubmit(): Promise<void> {
    this.submitting = true;

    const res = await axios.post('/api/tasks/', {
      title: this.title,
      description: this.description,
      position_index: this.lastTaskPosition ? this.lastTaskPosition + 1 : 1
    });

    this.submitting = false;
    this.title = null;
    this.description = null;
    this.createdResult.emit(res.data);
  }

}
